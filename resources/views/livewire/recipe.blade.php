<span>
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <a wire:click.prevent="setColumns(2)" class="btn btn-secondary">Two Columns</a>
                <a wire:click.prevent="setColumns(3)" class="btn btn-secondary">Three Columns</a>
                <a wire:click.prevent="toggleImages" class="btn btn-secondary">Show / Hide Images</a>
            </div>                
        </div>
        <div class="row mt-3">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <p>{{ $this-> recipe_description[0]['text']}}</p>
                    </div>
                    <div class="card-footer">
                        <small>Original URL: <a href="{{ $recipe->url }}" target="_blank">{{ $recipe->url }}</a></small>
                    </div>
                </div>
                
            </div>
        </div>
    </div>


    <h2>Ingredients</h2>
    <div class="container-fluid">
        <div class="row row-cols-1 row-cols-md-{{ $columns }} g-4">
            @foreach($this->recipe_ingredients as $index => $ingredient)
            <div class="col">
                <div class="card h-100 text-bg-secondary mb-3">
                    @if($ingredient['image'])
                    <img src="{{ $ingredient['image'] && $images }}" class="card-img-top" alt="...">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $ingredient['text'] }}</h5>
                    </div>
                    @if($ingredient['subtitle'])
                    <div class="card-footer">
                        <small>{{ $ingredient['subtitle'] ?? '' }}</small>
                    </div>
                    @endif
                    <div class="card-footer" onclick="this.parentElement.classList.toggle('text-bg-success')">
                        <a href="javascript:void(0)" class="btn stretched-link d-block">Mark as Done</a>
                    </div>
                </div>
            </div>
            @endforeach
            @foreach($this->pantry_ingredients as $index => $ingredient)
            <div class="col">
                <div class="card h-100 text-bg-secondary mb-3">
                    @if($ingredient['image'] && $images)
                    <img src="{{ $ingredient['image'] }}" class="card-img-top" alt="...">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $ingredient['text'] }}</h5>
                    </div>
                    @if($ingredient['subtitle'])
                    <div class="card-footer">
                        <small>{{ $ingredient['subtitle'] ?? '' }}</small>
                    </div>
                    @endif
                    <div class="card-footer" onclick="this.parentElement.classList.toggle('text-bg-success')">
                        <a href="javascript:void(0)" class="btn stretched-link d-block">Mark as Done</a>
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
                <div class="card h-100">
                    @if($step['image'] && $images)
                    <img src="{{ $step['image'] }}" class="card-img-top" alt="...">
                    @endif
                    <div class="card-header">Step {{ $index + 1 }}</div>
                    <div class="card-body">
                        <h5 class="card-title">{!! $step['text'] !!}</h5>
                    </div>
                    <div class="card-footer" onclick="this.classList.toggle('text-bg-success')">
                        <a href="javascript:void(0)" class="btn d-block">Mark as Done</a>
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

            window.setCookingTimer = function (minutes, name = null) {
                const timerId = name ?? timers.length + 1;
                const endTime = Date.now() + minutes * 60000;
                const timerDiv = document.createElement('div');
                timerDiv.className = 'alert pt-3 alert-warning timer';
                timerDiv.id = 'timer-' + timerId;
                const sound = new Audio('/storage/beep.mp3');
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
</span>