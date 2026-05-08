// Client-side WebRTC logic (mesh). Works on localhost (secure context) or HTTPS.
const roomInput = document.getElementById('room');
const nameInput = document.getElementById('name');
const joinBtn = document.getElementById('joinBtn');
const muteBtn = document.getElementById('muteBtn');
const cameraBtn = document.getElementById('cameraBtn');
const leaveBtn = document.getElementById('leaveBtn');
const shareBtn = document.getElementById('shareBtn');
const statusPill = document.getElementById('status');
const videos = document.getElementById('videos');
const videoTileTpl = document.getElementById('videoTile');

let ws;
let localStream;
let screenStream;
let myId = null;
let myName = null;
let roomId = null;

// Peer connections map: peerId -> RTCPeerConnection
const pcs = new Map();
// Media elements map: peerId -> <video>
const mediaEls = new Map();
// Track senders map: peerId -> { videoSender, audioSender }
const senders = new Map();

const rtcConfig = {
  iceServers: [
    { urls: ['stun:stun.l.google.com:19302'] },
    { urls: ['stun:global.stun.twilio.com:3478'] } // opsional
    // Untuk TURN (kalau perlu):
    // {
    //   urls: ['turn:turn.situskamu.com:3478?transport=udp'],
    //   username: 'userTURN',
    //   credential: 'passTURN'
    // }
  ]
};


function setStatus(text) {
  statusPill.style.display = 'inline-block';
  statusPill.textContent = text;
}

function addVideoTile(id, label) {
  const node = videoTileTpl.content.firstElementChild.cloneNode(true);
  const video = node.querySelector('video');
  const lab = node.querySelector('.label');
  lab.textContent = label;
  video.muted = (id === 'me');
  videos.appendChild(node);
  mediaEls.set(id, video);
  return video;
}

function removeVideoTile(id) {
  const video = mediaEls.get(id);
  if (video && video.parentElement) {
    video.parentElement.remove();
  }
  mediaEls.delete(id);
}

async function initLocalMedia() {
  localStream = await navigator.mediaDevices.getUserMedia({ video: true, audio: true });
  const v = addVideoTile('me', myName || 'Saya');
  v.srcObject = localStream;
  muteBtn.disabled = false;
  cameraBtn.disabled = false;
  shareBtn.disabled = false;
}

function createPc(peerId) {
  const pc = new RTCPeerConnection(rtcConfig);
  pcs.set(peerId, pc);

  // Add local tracks
  localStream.getTracks().forEach(track => {
    const sender = pc.addTrack(track, localStream);
  });

  pc.onicecandidate = (e) => {
    if (e.candidate) {
      ws.send(JSON.stringify({ type: 'ice-candidate', to: peerId, candidate: e.candidate }));
    }
  };

  pc.ontrack = (e) => {
    let video = mediaEls.get(peerId);
    if (!video) {
      video = addVideoTile(peerId, 'Peer ' + peerId);
    }
    if (!video.srcObject) {
      video.srcObject = new MediaStream();
    }
    e.streams[0].getTracks().forEach(t => video.srcObject.addTrack(t));
  };

  return pc;
}

async function callPeer(peerId) {
  const pc = createPc(peerId);
  const offer = await pc.createOffer();
  await pc.setLocalDescription(offer);
  ws.send(JSON.stringify({ type: 'offer', to: peerId, sdp: offer }));
}

async function handleOffer(fromId, sdp) {
  const pc = createPc(fromId);
  await pc.setRemoteDescription(new RTCSessionDescription(sdp));
  const answer = await pc.createAnswer();
  await pc.setLocalDescription(answer);
  ws.send(JSON.stringify({ type: 'answer', to: fromId, sdp: answer }));
}

async function handleAnswer(fromId, sdp) {
  const pc = pcs.get(fromId);
  if (!pc) return;
  await pc.setRemoteDescription(new RTCSessionDescription(sdp));
}

async function handleIceCandidate(fromId, candidate) {
  const pc = pcs.get(fromId);
  if (!pc) return;
  try {
    await pc.addIceCandidate(new RTCIceCandidate(candidate));
  } catch (err) {
    console.error('Error adding ICE candidate', err);
  }
}

function cleanupPeer(peerId) {
  const pc = pcs.get(peerId);
  if (pc) {
    pc.getSenders().forEach(s => {
      try { s.track && s.track.stop(); } catch {}
    });
    pc.close();
  }
  pcs.delete(peerId);
  removeVideoTile(peerId);
}

joinBtn.onclick = async () => {
  roomId = roomInput.value.trim();
  myName = nameInput.value.trim() || 'Pengguna';
  if (!roomId) {
    alert('Isi Room ID dulu ya');
    return;
  }
  await initLocalMedia();

  ws = new WebSocket((location.protocol === 'https:' ? 'wss://' : 'ws://') + location.host);
  ws.onopen = () => {
    setStatus('Terhubung');
    ws.send(JSON.stringify({ type: 'join', room: roomId, displayName: myName }));
  };
  ws.onmessage = async (ev) => {
    const msg = JSON.parse(ev.data);
    if (msg.type === 'welcome') {
      myId = msg.id;
      // Create tiles for myself label
      const myVideo = mediaEls.get('me');
      if (myVideo && myVideo.parentElement) {
        myVideo.parentElement.querySelector('.label').textContent = myName + ' (Saya)';
      }
      // Call existing peers
      for (const p of msg.peers) {
        callPeer(p.id);
      }
      leaveBtn.disabled = false;
    }
    if (msg.type === 'peer-joined') {
      // Create connection and offer to the new peer
      callPeer(msg.id);
    }
    if (msg.type === 'offer') await handleOffer(msg.from, msg.sdp);
    if (msg.type === 'answer') await handleAnswer(msg.from, msg.sdp);
    if (msg.type === 'ice-candidate') await handleIceCandidate(msg.from, msg.candidate);
    if (msg.type === 'peer-left') cleanupPeer(msg.id);
  };
  ws.onclose = () => {
    setStatus('Terputus');
  };
};

muteBtn.onclick = () => {
  if (!localStream) return;
  const enabled = localStream.getAudioTracks().some(t => t.enabled);
  localStream.getAudioTracks().forEach(t => t.enabled = !enabled);
  muteBtn.textContent = enabled ? 'Unmute' : 'Mute';
};

cameraBtn.onclick = () => {
  if (!localStream) return;
  const enabled = localStream.getVideoTracks().some(t => t.enabled);
  localStream.getVideoTracks().forEach(t => t.enabled = !enabled);
  cameraBtn.textContent = enabled ? 'Nyalakan Kamera' : 'Matikan Kamera';
};

leaveBtn.onclick = () => {
  // Close connections
  for (const [peerId] of pcs) cleanupPeer(peerId);
  // Stop local media
  if (localStream) {
    localStream.getTracks().forEach(t => t.stop());
  }
  // Close WS
  if (ws && ws.readyState === WebSocket.OPEN) ws.close();
  // UI reset
  videos.innerHTML = '';
  muteBtn.disabled = true;
  cameraBtn.disabled = true;
  shareBtn.disabled = true;
  leaveBtn.disabled = true;
  setStatus('');
};

shareBtn.onclick = async () => {
  try {
    if (!screenStream) {
      screenStream = await navigator.mediaDevices.getDisplayMedia({ video: true, audio: true });
      replaceVideoTrack(screenStream.getVideoTracks()[0]);
      shareBtn.textContent = 'Stop Share';
      screenStream.getVideoTracks()[0].onended = () => {
        stopScreenShare();
      };
    } else {
      stopScreenShare();
    }
  } catch (err) {
    console.error('Share screen gagal:', err);
  }
};

function stopScreenShare() {
  if (!screenStream) return;
  const track = screenStream.getVideoTracks()[0];
  if (track) track.stop();
  screenStream = null;
  // Revert to camera
  const camTrack = localStream.getVideoTracks()[0];
  replaceVideoTrack(camTrack);
  shareBtn.textContent = 'Share Screen';
}

function replaceVideoTrack(newTrack) {
  // Update local stream
  const oldTrack = localStream.getVideoTracks()[0];
  if (oldTrack) {
    localStream.removeTrack(oldTrack);
    oldTrack.stop();
  }
  localStream.addTrack(newTrack);
  const myVideo = mediaEls.get('me');
  if (myVideo) {
    myVideo.srcObject = localStream;
  }
  // Replace sender track in each PC
  for (const [peerId, pc] of pcs.entries()) {
    const sender = pc.getSenders().find(s => s.track && s.track.kind === 'video');
    if (sender) {
      sender.replaceTrack(newTrack);
    }
  }
}
