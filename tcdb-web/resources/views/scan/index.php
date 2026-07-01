<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scan Employee ID (Barcode)</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #6366f1;
            --bg-color: #000000;
            --text-color: #f8fafc;
            --card-bg: rgba(30, 41, 59, 0.7);
            --border-color: rgba(255, 255, 255, 0.1);
            --input-bg: rgba(15, 23, 42, 0.5);
            --color-green: #22c55e;
            --color-red: #ef4444;
        }
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-color);
            margin: 0;
            padding: 2rem;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .container {
            width: 100%;
            max-width: 1400px;
        }
        header {
            display: grid;
            grid-template-columns: 1fr auto 1fr;
            align-items: center;
            margin-bottom: 2rem;
            width: 100%;
        }
        .header-title {
            justify-self: start;
        }
        .header-center {
            justify-self: center;
        }
        .header-right {
            justify-self: end;
        }
        h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin: 0;
            background: linear-gradient(to right, #e96107ff, #976935ff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .glass-panel {
            background: var(--card-bg);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 3rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            text-align: center;
        }
        input {
            width: 100%;
            min-width: 350px;
            max-width: 400px;
            padding: 1rem;
            border-radius: 8px;
            border: 2px solid var(--border-color);
            background-color: var(--input-bg);
            color: white;
            font-family: inherit;
            font-size: 1.25rem;
            text-align: center;
            box-sizing: border-box;
            transition: border-color 0.2s ease;
        }
        input:focus {
            outline: none;
            border-color: var(--primary);
        }
        .status-box {
            width: 100%;
            max-width: 100%;
            height: 500px;
            margin: 0 auto;
            border-radius: 32px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 15rem;
            font-weight: 700;
            letter-spacing: 8px;
            transition: all 0.3s ease;
            box-shadow: 0 20px 50px -5px rgba(0, 0, 0, 0.5);
        }
        .status-box.white {
            background-color: white;
            color: #94a3b8;
            font-size: 4rem; 
            box-shadow: 0 0 15px rgba(255,255,255,0.2);
        }
        .status-box.green {
            background-color: var(--color-green);
            color: white;
            box-shadow: 0 0 40px rgba(34, 197, 94, 0.7);
        }
        .status-box.red {
            background-color: var(--color-red);
            color: white;
            box-shadow: 0 0 40px rgba(239, 68, 68, 0.7);
        }
        .btn-secondary {
            display: inline-block;
            margin-top: 2rem;
            color: #94a3b8;
            text-decoration: none;
            border: 1px solid var(--border-color);
            padding: 0.5rem 1rem;
            border-radius: 8px;
            transition: all 0.2s;
        }
        .btn-secondary:hover {
            background-color: rgba(255,255,255,0.1);
            color: white;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            body { padding: 1rem; }
            h1 { font-size: 2rem; }
            .glass-panel { padding: 2rem 1.5rem; }
            .status-box { font-size: 8rem; height: 350px; }
            .status-box.white { font-size: 3rem; }
            header {
                grid-template-columns: 1fr;
                gap: 1rem;
                justify-items: center;
            }
            .header-title, .header-center, .header-right {
                justify-self: center;
            }
        }
        
        @media (max-width: 480px) {
            h1 { font-size: 1.75rem; }
            .btn-secondary { margin-top: 0; }
            input { font-size: 1rem; padding: 0.75rem; min-width: 250px; }
            .status-box { font-size: 5rem; height: 250px; }
            .status-box.white { font-size: 2rem; }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <div class="header-title">
                <h1>Barcode/ID Scanner</h1>
            </div>
            <div class="header-center">
                <input type="text" id="scan_input" placeholder="Scan Barcode or Enter ID here" autofocus autocomplete="off">
            </div>
            <div class="header-right">
                <a href="/" class="btn-secondary" style="margin-top: 0;">Back to Directory</a>
            </div>
        </header>
        
        <div class="glass-panel">
            <div id="status_box" class="status-box white">READY</div>
        </div>
    </div>

    <script>
        const input = document.getElementById('scan_input');
        const statusBox = document.getElementById('status_box');
        let resetTimer = null;

        // Web Audio API Context (created on first user interaction)
        let audioCtx;
        
        function initAudio() {
            if (!audioCtx) {
                audioCtx = new (window.AudioContext || window.webkitAudioContext)();
            }
            if (audioCtx.state === 'suspended') {
                audioCtx.resume();
            }
        }

        function playSound(type) {
            initAudio();
            const oscillator = audioCtx.createOscillator();
            const gainNode = audioCtx.createGain();
            
            oscillator.connect(gainNode);
            gainNode.connect(audioCtx.destination);
            
            if (type === 'pass') {
                // High pleasant beep
                oscillator.type = 'sine';
                oscillator.frequency.setValueAtTime(880, audioCtx.currentTime); // A5
                gainNode.gain.setValueAtTime(0.5, audioCtx.currentTime);
                gainNode.gain.exponentialRampToValueAtTime(0.01, audioCtx.currentTime + 0.3);
                oscillator.start();
                oscillator.stop(audioCtx.currentTime + 0.3);
            } else {
                // Low buzz
                oscillator.type = 'sawtooth';
                oscillator.frequency.setValueAtTime(150, audioCtx.currentTime);
                gainNode.gain.setValueAtTime(0.5, audioCtx.currentTime);
                gainNode.gain.exponentialRampToValueAtTime(0.01, audioCtx.currentTime + 0.5);
                oscillator.start();
                oscillator.stop(audioCtx.currentTime + 0.5);
            }
        }

        function setStatus(status) {
            if (resetTimer) clearTimeout(resetTimer);

            if (status === 'pass') {
                statusBox.className = 'status-box green';
                statusBox.textContent = 'PASS';
                playSound('pass');
            } else if (status === 'hold') {
                statusBox.className = 'status-box red';
                statusBox.textContent = 'HOLD';
                playSound('hold');
            }

            // Reset after 3 seconds
            resetTimer = setTimeout(() => {
                resetView();
            }, 3000);
        }

        function resetView() {
            statusBox.className = 'status-box white';
            statusBox.textContent = 'READY';
            input.focus();
        }

        // Click anywhere focuses input
        document.addEventListener('click', () => {
            input.focus();
        });

        input.addEventListener('keyup', function(e) {
            // Need user interaction first to allow audio
            initAudio();
            
            if (e.key === 'Enter') {
                const idVal = input.value.trim();
                input.value = ''; // clear input
                if (!idVal) return;

                fetch('/scan/check', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ id: idVal })
                })
                .then(res => res.json())
                .then(data => {
                    setStatus(data.status);
                })
                .catch(err => {
                    console.error('Error:', err);
                    setStatus('hold');
                });
            }
        });
    </script>
</body>
</html>
