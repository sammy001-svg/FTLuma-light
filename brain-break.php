<?php
require_once 'functions.php';

$page_title = 'Brain Break | Lucky Cup Game';
include 'includes/header.php';
?>

<section class="hero" style="padding: 6rem 0; background: linear-gradient(135deg, var(--primary-900), var(--primary-700)); color: white;">
    <div class="container" style="text-align: center;">
        <span class="badge" style="background: var(--primary-500); border: none; margin-bottom: 1rem;">INTERACTIVE MINI-GAME</span>
        <h1 style="font-size: 4rem; margin-bottom: 1rem;">Brain <span class="text-gradient" style="background: linear-gradient(135deg, #fff, var(--primary-300)); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Break</span></h1>
        <p style="color: var(--primary-100); max-width: 600px; margin: 0 auto;">Take a moment to refresh your mind. Can you find the golden pearl hidden under the cups?</p>
    </div>
</section>

<main class="container" style="padding: 5rem 0;">
    <div class="game-container" id="game-container">
        <div class="level-indicator">Level: <span id="level">1</span></div>
        <div class="game-status" id="game-status">Click "Start Game" to begin!</div>
        
        <div class="cups-wrapper" id="cups-wrapper">
            <div class="cup-item" id="cup-0" data-index="0" style="left: 0%;">
                <div class="cup">
                    <div class="cup-body"></div>
                </div>
                <div class="ball" id="ball"></div>
            </div>
            <div class="cup-item" id="cup-1" data-index="1" style="left: 33.33%;">
                <div class="cup">
                    <div class="cup-body"></div>
                </div>
            </div>
            <div class="cup-item" id="cup-2" data-index="2" style="left: 66.66%;">
                <div class="cup">
                    <div class="cup-body"></div>
                </div>
            </div>
        </div>

        <div class="game-controls">
            <button id="start-btn" class="btn-primary" style="padding: 1rem 3rem; font-size: 1.25rem;">Start Game</button>
            <button id="reset-btn" class="btn-primary" style="padding: 1rem 3rem; font-size: 1.25rem; display: none; background: var(--primary-800);">Try Again</button>
        </div>
        
        <div class="score-board">
            <div class="score-item">Wins: <span id="wins">0</span></div>
            <div class="score-item">Losses: <span id="losses">0</span></div>
            <div class="score-item">Streak: <span id="streak">0</span></div>
        </div>
    </div>
</main>

<style>
.game-container {
    max-width: 800px;
    margin: 0 auto;
    background: var(--bg-white);
    border-radius: 2rem;
    padding: 4rem;
    border: 1px solid var(--border);
    box-shadow: var(--shadow-lg);
    text-align: center;
    position: relative;
    overflow: hidden;
}

.level-indicator {
    position: absolute;
    top: 2rem;
    right: 2rem;
    background: var(--primary-100);
    color: var(--primary-800);
    padding: 0.5rem 1.5rem;
    border-radius: 2rem;
    font-weight: 800;
    font-size: 1.125rem;
}

.game-status {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--primary-800);
    margin-bottom: 4rem;
    min-height: 2.25rem;
}

.cups-wrapper {
    position: relative;
    height: 180px;
    margin: 0 auto 5rem;
    max-width: 500px;
}

.cup-item {
    position: absolute;
    top: 0;
    width: 100px;
    cursor: pointer;
    transition: left 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

.cup {
    position: relative;
    z-index: 10;
    transition: transform 0.5s ease;
}

.cup-body {
    width: 100px;
    height: 120px;
    background: linear-gradient(135deg, var(--primary-700), var(--primary-900));
    clip-path: polygon(10% 0%, 90% 0%, 100% 100%, 0% 100%);
    border-radius: 8px 8px 0 0;
    position: relative;
    box-shadow: 0 10px 20px rgba(0,0,0,0.2);
}

.cup-body::after {
    content: '';
    position: absolute;
    top: 5px;
    left: 10px;
    right: 10px;
    height: 10px;
    background: rgba(255,255,255,0.1);
    border-radius: 5px;
}

.ball {
    position: absolute;
    bottom: 5px;
    left: 50%;
    transform: translateX(-50%);
    width: 35px;
    height: 35px;
    background: radial-gradient(circle at 30% 30%, #ffd700, #b8860b);
    border-radius: 50%;
    z-index: 1;
    display: none;
    box-shadow: 0 4px 8px rgba(0,0,0,0.3);
}

.cup-item.lift .cup {
    transform: translateY(-90px) rotate(-15deg);
}

.game-controls {
    display: flex;
    justify-content: center;
    gap: 1.5rem;
    margin-bottom: 3rem;
}

.score-board {
    display: flex;
    justify-content: center;
    gap: 3rem;
    font-weight: 700;
    color: var(--text-muted);
    border-top: 1px solid var(--border);
    padding-top: 2rem;
}

.score-item span {
    color: var(--primary-700);
}

.shuffling .cup-item {
    cursor: not-allowed;
    pointer-events: none;
}

@media (max-width: 768px) {
    .game-container {
        padding: 2.25rem 1.25rem !important;
        border-radius: 1.5rem !important;
    }
    .level-indicator {
        position: relative !important;
        top: 0 !important;
        right: 0 !important;
        display: inline-block !important;
        margin-bottom: 1.5rem !important;
    }
    .game-status {
        margin-bottom: 2rem !important;
        font-size: 1.35rem !important;
        line-height: 1.3 !important;
    }
    .score-board {
        gap: 1.25rem !important;
        flex-wrap: wrap !important;
        justify-content: center !important;
    }
    .score-item {
        font-size: 0.95rem !important;
    }
    main .container, main {
        margin-bottom: 4rem !important;
    }
}

@media (max-width: 600px) {
    .cups-wrapper {
        height: 150px;
    }
    .cup-body {
        width: 80px;
        height: 100px;
    }
    .cup-item {
        width: 80px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const startBtn = document.getElementById('start-btn');
    const resetBtn = document.getElementById('reset-btn');
    const status = document.getElementById('game-status');
    const levelEl = document.getElementById('level');
    const winsEl = document.getElementById('wins');
    const lossesEl = document.getElementById('losses');
    const streakEl = document.getElementById('streak');
    const ball = document.getElementById('ball');
    const cupItems = [
        document.getElementById('cup-0'),
        document.getElementById('cup-1'),
        document.getElementById('cup-2')
    ];

    let gameState = {
        level: 1,
        wins: 0,
        losses: 0,
        streak: 0,
        ballIndex: 0, // Which cup (by current position) has the ball
        positions: [0, 1, 2], // Current left position index for each cup element
        isShuffling: false
    };

    const levels = {
        1: { shuffles: 5, speed: 600 },
        2: { shuffles: 8, speed: 500 },
        3: { shuffles: 12, speed: 400 },
        4: { shuffles: 15, speed: 300 },
        5: { shuffles: 20, speed: 200 }
    };

    startBtn.addEventListener('click', startGame);
    resetBtn.addEventListener('click', startGame);

    function startGame() {
        startBtn.style.display = 'none';
        resetBtn.style.display = 'none';
        status.textContent = 'Watch the ball...';
        status.style.color = 'var(--primary-800)';
        
        // Reset state
        gameState.positions = [0, 1, 2];
        cupItems.forEach(cup => {
            cup.classList.remove('lift');
            cup.style.zIndex = '10';
        });
        
        // Reset positions visually
        updateVisualPositions();
        
        // Randomize ball starting position
        gameState.ballIndex = Math.floor(Math.random() * 3);
        const winningCup = cupItems.find(cup => parseInt(cup.getAttribute('data-index')) === gameState.ballIndex);
        winningCup.appendChild(ball);
        
        // Reveal ball
        setTimeout(() => {
            ball.style.display = 'block';
            winningCup.classList.add('lift');
            
            setTimeout(() => {
                winningCup.classList.remove('lift');
                // Hide ball strictly when cup covers it
                setTimeout(() => {
                    ball.style.display = 'none';
                    startShuffling();
                }, 400);
            }, 1000);
        }, 500);
    }

    function startShuffling() {
        gameState.isShuffling = true;
        document.getElementById('game-container').classList.add('shuffling');
        status.textContent = 'Shuffling...';

        let count = 0;
        const config = levels[Math.min(gameState.level, 5)];
        
        const shuffleTimer = setInterval(() => {
            performSwap();
            count++;
            
            if (count >= config.shuffles) {
                clearInterval(shuffleTimer);
                setTimeout(endShuffling, config.speed);
            }
        }, config.speed);
    }

    function performSwap() {
        // Pick two random positions to swap
        const idx1 = Math.floor(Math.random() * 3);
        let idx2 = Math.floor(Math.random() * 3);
        while (idx1 === idx2) idx2 = Math.floor(Math.random() * 3);
        
        // Swap values in positions array
        const temp = gameState.positions[idx1];
        gameState.positions[idx1] = gameState.positions[idx2];
        gameState.positions[idx2] = temp;
        
        // Dynamic z-index for realistic overlapping
        cupItems[idx1].style.zIndex = 20;
        cupItems[idx2].style.zIndex = 10;
        
        updateVisualPositions();
    }

    function updateVisualPositions() {
        const leftCoords = ['0%', '33.33%', '66.66%'];
        cupItems.forEach((cup, i) => {
            cup.style.left = leftCoords[gameState.positions[i]];
        });
    }

    function endShuffling() {
        gameState.isShuffling = false;
        document.getElementById('game-container').classList.remove('shuffling');
        status.textContent = 'Where is the pearl?';
        
        cupItems.forEach(cup => {
            cup.onclick = () => handleChoice(cup);
        });
    }

    function handleChoice(selectedCup) {
        if (gameState.isShuffling) return;
        
        cupItems.forEach(cup => cup.onclick = null);
        
        const selectedIndex = parseInt(selectedCup.getAttribute('data-index'));
        const winningCup = cupItems.find(cup => parseInt(cup.getAttribute('data-index')) === gameState.ballIndex);
        
        winningCup.appendChild(ball);
        ball.style.display = 'block';
        
        // Lift all cups to reveal
        cupItems.forEach(cup => cup.classList.add('lift'));
        
        if (selectedIndex === gameState.ballIndex) {
            status.textContent = '🎉 CORRECT! Level Up!';
            status.style.color = '#059669';
            gameState.wins++;
            gameState.streak++;
            
            // Level up logic
            if (gameState.streak % 2 === 0) {
                gameState.level++;
                levelEl.textContent = gameState.level;
            }
        } else {
            status.textContent = '❌ Ouch! It was over there.';
            status.style.color = '#dc2626';
            gameState.losses++;
            gameState.streak = 0;
            
            // Level down slightly if streak broken at high levels
            if (gameState.level > 1) {
                gameState.level--;
                levelEl.textContent = gameState.level;
            }
        }
        
        winsEl.textContent = gameState.wins;
        lossesEl.textContent = gameState.losses;
        streakEl.textContent = gameState.streak;
        
        resetBtn.style.display = 'inline-block';
    }
});
</script>

<?php include 'includes/footer.php'; ?>
