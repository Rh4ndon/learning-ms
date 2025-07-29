<!-- Session Check -->
<?php include '../../controllers/sessions.php'; ?>

<!-- Header -->
<?php include 'header.php'; ?>

<!-- Sidebar -->
<?php include 'sidebar.php'; ?>

<style>
    /* Scoped gamification styles */
    .exam-creation-container .creation-card {
        transition: all 0.3s ease;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        background: linear-gradient(135deg, #f8f9fa, #ffffff);
    }

    .exam-creation-container .creation-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    }

    .exam-creation-container .creation-header {
        background: linear-gradient(135deg, #6e8efb, #a777e3);
        color: white;
        border-radius: 10px 10px 0 0 !important;
    }

    .exam-creation-container .creation-badge {
        position: absolute;
        top: -10px;
        right: 20px;
        background: gold;
        color: #333;
        padding: 5px 15px;
        border-radius: 20px;
        font-weight: bold;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
        animation: bounce 2s infinite;
    }

    @keyframes bounce {

        0%,
        100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-5px);
        }
    }

    .exam-creation-container .create-btn {
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .exam-creation-container .create-btn:hover {
        transform: scale(1.05);
    }

    .exam-creation-container .create-btn::after {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: rgba(255, 255, 255, 0.2);
        transform: rotate(30deg);
        transition: all 0.5s ease;
    }

    .exam-creation-container .create-btn:hover::after {
        left: 100%;
    }

    /* Sound Controls */
    .creation-sound-control {
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 1000;
        background: rgba(0, 0, 0, 0.7);
        color: white;
        border-radius: 50%;
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    /* Achievement Notification */
    .creation-achievement-notification {
        position: fixed;
        bottom: 80px;
        right: 20px;
        background: linear-gradient(135deg, #6e8efb, #a777e3);
        color: white;
        padding: 15px 20px;
        border-radius: 8px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        z-index: 1000;
        transform: translateX(200%);
        transition: transform 0.5s ease;
        display: flex;
        align-items: center;
        max-width: 300px;
    }

    .creation-achievement-notification.show {
        transform: translateX(0);
    }

    /* Exam cards */
    .exam-creation-container .exam-card {
        transition: all 0.3s ease;
        border-left: 4px solid #6e8efb;
    }

    .exam-creation-container .exam-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    /* Progress indicator */
    .creation-progress {
        height: 8px;
        background: #e9ecef;
        border-radius: 4px;
        margin: 15px 0;
        overflow: hidden;
    }

    .creation-progress-bar {
        height: 100%;
        background: linear-gradient(90deg, #4b6cb7, #182848);
        width: 0%;
        transition: width 1s ease;
    }
</style>

<!-- Main Content -->
<div class="main-content exam-creation-container">
    <!-- Top Navbar -->
    <?php include 'top-navbar.php'; ?>

    <!-- Dashboard Content -->
    <div class="container-fluid">
        <!-- Creation Section -->
        <div class="row mt-4">


            <?php include '../../controllers/get-section-records.php'; ?>


        </div>
    </div>
</div>

<!-- Sound Control -->
<div class="creation-sound-control" id="creationSoundControl" onclick="toggleCreationSound()">
    <i class="fas fa-volume-up" id="creationSoundIcon"></i>
</div>

<!-- Achievement Notification -->
<div class="creation-achievement-notification" id="creationAchievementNotification">
    <i class="fas fa-trophy mr-2"></i>
    <span id="creationAchievementText">Achievement Unlocked!</span>
</div>

<!-- Audio Elements -->
<audio id="creationBackgroundMusic" loop>
    <source src="../assets/sounds/game-music-loop-6.mp3" type="audio/mpeg">
</audio>
<audio id="creationAchievementSound">
    <source src="../assets/sounds/small-win.mp3" type="audio/mpeg">
</audio>
<audio id="creationHoverSound">
    <source src="../assets/sounds/win-chime.mp3" type="audio/mpeg">
</audio>
<audio id="creationClickSound">
    <source src="../assets/sounds/click.mp3" type="audio/mpeg">
</audio>

<script>
    // Creation Game State
    const creationGameState = {
        soundEnabled: true,
        xp: 0,
        level: 1,
        xpToNextLevel: 100,
        examsCreated: <?php echo count(getAllRecords('quizzes')); ?>,
        quests: {
            createExams: {
                target: 5,
                current: <?php echo count(getAllRecords('quizzes')); ?>,
                completed: false
            }
        }
    };

    // DOM Elements
    const creationSoundControl = document.getElementById('creationSoundControl');
    const creationSoundIcon = document.getElementById('creationSoundIcon');
    const creationBackgroundMusic = document.getElementById('creationBackgroundMusic');
    const creationAchievementSound = document.getElementById('creationAchievementSound');
    const creationHoverSound = document.getElementById('creationHoverSound');
    const creationClickSound = document.getElementById('creationClickSound');
    const creationAchievementNotification = document.getElementById('creationAchievementNotification');
    const creationAchievementText = document.getElementById('creationAchievementText');
    const creationCards = document.querySelectorAll('.creation-card, .exam-card');
    const actionButtons = document.querySelectorAll('.action-btn, .create-btn');


    // Initialize
    document.addEventListener('DOMContentLoaded', function() {
        // Load saved game state
        loadCreationGameState();


        // Initialize sound
        initCreationSound();

        // Add hover effects
        addCreationHoverEffects();

        // Check for achievements
        checkCreationAchievements();


    });

    // Initialize sound system
    function initCreationSound() {
        // Set volume levels
        creationBackgroundMusic.volume = 0.3;
        creationAchievementSound.volume = 0.6;
        creationHoverSound.volume = 0.2;
        creationClickSound.volume = 0.5;

        // Try to play background music
        if (creationGameState.soundEnabled) {
            const playPromise = creationBackgroundMusic.play();

            if (playPromise !== undefined) {
                playPromise.catch(error => {
                    console.log("Autoplay prevented, waiting for user interaction");
                    document.body.addEventListener('click', () => {
                        creationBackgroundMusic.play().catch(e => console.log("Still unable to play:", e));
                    }, {
                        once: true
                    });
                });
            }
        }

        // Update sound icon
        creationSoundIcon.className = creationGameState.soundEnabled ? 'fas fa-volume-up' : 'fas fa-volume-mute';
    }

    // Toggle sound
    function toggleCreationSound() {
        creationGameState.soundEnabled = !creationGameState.soundEnabled;

        if (creationGameState.soundEnabled) {
            creationSoundIcon.className = 'fas fa-volume-up';
            creationBackgroundMusic.play().catch(e => console.log("Play failed:", e));
        } else {
            creationSoundIcon.className = 'fas fa-volume-mute';
            creationBackgroundMusic.pause();
        }

        saveCreationGameState();
    }

    // Play click sound
    function playClickSound() {
        if (creationGameState.soundEnabled) {
            creationClickSound.currentTime = 0;
            creationClickSound.play().catch(e => console.log("Click sound error:", e));
        }
    }

    // Add hover effects to cards and buttons
    function addCreationHoverEffects() {
        creationCards.forEach(card => {
            card.addEventListener('mouseenter', () => {
                if (creationGameState.soundEnabled) {
                    creationHoverSound.currentTime = 0;
                    creationHoverSound.play().catch(e => console.log("Hover sound error:", e));
                }
            });
        });

        actionButtons.forEach(button => {
            button.addEventListener('mouseenter', () => {
                if (creationGameState.soundEnabled) {
                    creationHoverSound.currentTime = 0;
                    creationHoverSound.play().catch(e => console.log("Hover sound error:", e));
                }
            });
        });
    }



    // Load game state
    function loadCreationGameState() {
        const savedState = localStorage.getItem('creationGameState');
        if (savedState) {
            Object.assign(creationGameState, JSON.parse(savedState));
        }
    }

    // Save game state
    function saveCreationGameState() {
        localStorage.setItem('creationGameState', JSON.stringify(creationGameState));
    }



    // Check for achievements
    function checkCreationAchievements() {
        // Check creation quest
        if (!creationGameState.quests.createExams.completed &&
            creationGameState.quests.createExams.current >= creationGameState.quests.createExams.target) {
            creationGameState.quests.createExams.completed = true;
            awardCreationXP(50, "Exam Creator Master!");
        }

        saveCreationGameState();
    }

    // Award XP
    function awardCreationXP(amount, message) {
        creationGameState.xp += amount;

        // Check for level up
        while (creationGameState.xp >= creationGameState.xpToNextLevel) {
            creationGameState.xp -= creationGameState.xpToNextLevel;
            creationGameState.level++;
            creationGameState.xpToNextLevel = Math.floor(creationGameState.xpToNextLevel * 1.2);

            showCreationAchievement(`Level Up! Now Level ${creationGameState.level}`);
        }

        if (message) {
            showCreationAchievement(message);
        }

        saveCreationGameState();
    }

    // Show achievement
    function showCreationAchievement(message) {
        if (creationGameState.soundEnabled) {
            creationAchievementSound.currentTime = 0;
            creationAchievementSound.play().catch(e => console.log("Achievement sound error:", e));
        }

        creationAchievementText.textContent = message;
        creationAchievementNotification.classList.add('show');

        setTimeout(() => {
            creationAchievementNotification.classList.remove('show');
        }, 3000);
    }
</script>

<!-- Footer -->
<?php include 'footer.php'; ?>