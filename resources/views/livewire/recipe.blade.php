<div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-8">
                <p>{{ $this-> recipe_description[0]['text']}}</p>
            </div>
            <div class="col-4">
                <a wire:click.prevent="setColumns(2)" class="btn btn-secondary">Two Columns</a>
                <a wire:click.prevent="setColumns(3)" class="btn btn-secondary">Three Columns</a>
                <a wire:click.prevent="toggleImages" class="btn btn-secondary">Show / Hide Images</a>
            </div>
        </div>
    </div>


    <h2>Ingredients</h2>
    <div class="container-fluid">
        <div class="row row-cols-1 row-cols-md-{{ $columns }} g-4">
            @foreach($this->recipe_ingredients as $index => $ingredient)
            <div class="col">
                <div class="card h-100 text-bg-secondary mb-3" onclick="this.classList.toggle('text-bg-success')">
                    @if($ingredient['image'])
                    <img src="{{ $ingredient['image'] && $images }}" class="card-img-top" alt="...">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $ingredient['text'] }}</h5>
                    </div>
                    <div class="card-footer">
                        <small>{{ $ingredient['subtitle'] ?? '' }}</small>
                    </div>
                </div>
            </div>
            @endforeach
            @foreach($this->pantry_ingredients as $index => $ingredient)
            <div class="col">
                <div class="card h-100 text-bg-secondary mb-3" onclick="this.classList.toggle('text-bg-success')">
                    @if($ingredient['image'] && $images)
                    <img src="{{ $ingredient['image'] }}" class="card-img-top" alt="...">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $ingredient['text'] }}</h5>
                    </div>
                    <div class="card-footer">
                        <small>{{ $ingredient['subtitle'] ?? '' }}</small>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    <hr />
    <h2>Steps</h2>
    <div class="container-fluid">
        <div class="row row-cols-1 row-cols-md-{{ $columns }} g-4">
            @foreach($this->recipe_steps as $index => $step)
            <div class="col">
                <div class="card h-100" onclick="this.classList.toggle('text-bg-success')">
                    @if($step['image'] && $images)
                    <img src="{{ $step['image'] }}" class="card-img-top" alt="...">
                    @endif
                    <div class="card-header">Step {{ $index + 1 }}</div>
                    <div class="card-body">
                        <h5 class="card-title">{!! $step['text'] !!}</h5>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <nav class="navbar sticky-bottom text-bg-secondary">
        <div class="container-fluid" id="timerList">

        </div>
    </nav>

    <script>
        (function () {
            let timers = [];

            window.setCookingTimer = function (minutes) {
                minutes = 0.05
                const timerId = timers.length + 1;
                const endTime = Date.now() + minutes * 60000;
                const timerDiv = document.createElement('div');
                timerDiv.className = 'alert alert-warning timer';
                timerDiv.id = 'timer-' + timerId;
                const sound = new Audio('path/to/sound.mp3');
                sound.loop = true;

                function updateTimer() {
                    const now = Date.now();
                    const timeLeft = Math.max(0, endTime - now);
                    const minutesLeft = Math.floor(timeLeft / 60000);
                    const secondsLeft = Math.floor((timeLeft % 60000) / 1000);
                    const formattedTime = `${minutesLeft}m ${secondsLeft}s`;

                    if (timeLeft === 0) {
                        timerDiv.classList.add('alert-danger');
                        sound.play();
                    }

                    timerDiv.innerHTML = `<i class="bi-stopwatch-fill"></i> Timer #${timerId}: ${formattedTime} remaining`;
                }

                updateTimer();
                const interval = setInterval(() => {
                    updateTimer();
                    if (Date.now() >= endTime) {
                        clearInterval(interval);
                    }
                }, 1000);

                timerDiv.addEventListener('click', () => {
                    if (timerDiv.classList.contains('alert-danger')) {
                        sound.pause();
                        timerDiv.classList.remove('alert-danger');
                        timerDiv.classList.remove('alert-warning');
                        timerDiv.classList.add('alert-success');
                    }
                });

                document.getElementById('timerList').appendChild(timerDiv);
                timers.push({ id: timerId, interval, timerDiv });
            };
        })()


    </script>
</div>