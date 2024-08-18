<span>
    <div class="container-fluid">
        <div class="row">
            <div class="col d-flex justify-content-end">
                <a wire:confirm="Are you sure you want to remove this recipe?" wire:click.prevent="deleteRecipe"
                    class="btn btn-danger">Remove Recipe</a>
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
        <div class="row row-cols-1 row-cols-md-3 g-4">
            @foreach($this->recipe_ingredients as $index => $ingredient)
            <div class="col">
                <div class="card h-100 text-bg-secondary mb-3">
                    @if($ingredient['image'])
                    <img src="{{ $ingredient['image'] && $images }}" class="card-img-top" alt="...">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $ingredient['text'] }}</h5>
                        @if($ingredient['subtitle'])<small>{{ $ingredient['subtitle'] ?? '' }}</small>@endif
                    </div>
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
                        @if($ingredient['subtitle'])<small>{{ $ingredient['subtitle'] ?? '' }}</small>@endif
                    </div>

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
                // Set a timer ID
                const timerID = timers.length + 1;

                // Set up our timer object
                timers[timerID] = {
                    _interval: null, // This holds our setInterval
                    _now: Date.now(), // Set now() to represent a static point in time when the timer was created
                    _sound: null, // Holds our Audio() object
                    get _timeLeft() { // Returns the number of milliseconds until the timer is done
                        return Math.max(0, this.endTime - Date.now())
                    },
                    _div: null, // Holds our DIV that is created and appended to the timer list
                    id: timerID, // The ID of this timer. Used to create the timer name if you don't specify one
                    name: name ?? 'Timer #' + timerID, // The name of the timer. Defaults to "Timer #1" (or whatever timerID is)
                    minutes: minutes, // How many minutes should this timer run for?
                    endTime: null, // A timestamp that represents when the timer will end
                    get div() { // If we haven't set up the DIV before, set it up, otherwise return the already set up DIV
                        if (!this._div) {
                            this._div = document.createElement('div')
                            this._div.className = 'alert pt-3 alert-info timer'
                            this._div.id = this.id
                        }
                        return this._div
                    },
                    get sound() { // Same as div (sets up the Audio object if not already)
                        if (!this._sound) {
                            this._sound = new Audio('/storage/beep.mp3')
                            this._sound.loop = true
                        }

                        return this._sound
                    },
                    get timeLeft() { // Returns the amount of time remaining, formatted as minutes / seconds (e.g. 9m5s)
                        const minutesLeft = Math.floor(this._timeLeft / 60000)
                        const secondsLeft = Math.floor((this._timeLeft % 60000) / 1000)
                        return `${minutesLeft}m ${secondsLeft}s`
                    },

                    state: 0, // 0 = Paused, 1 = Running, 2 = Done, 3 = Acknowledged

                    updateTimer() { // This is called by setInterval and handles playing the sound and updating the DIV's text
                        if(this.state != 1) { // Don't do anything if we're paused, done or acknowledged
                            return
                        }
                        this.endTime = this._now + this.minutes * 60000;
                        this.div.innerHTML = `<i class="bi-stopwatch-fill"></i> ${this.name}: ${this.timeLeft} remaining`;
                        if (this._timeLeft <= 0) {
                            this.sound.play()
                        }
                    },

                    startTimer() { // Start the timer
                        this.handleClicks() // Set up click events so when you click on the timer boxes, they do stuff
                        document.getElementById('timerList').appendChild(this.div) // Add the timer box to the timer list
                        this.state = 1 // Set the state as running
                        this._interval = setInterval(() => { // Set up our setInterval
                            this.updateTimer() // Update the timer
                            if (Date.now() >= this.endTime) { // If the timer is up
                                this.state = 2 // Set the state to 2, Done
                                clearInterval(this._interval) // Stop updating

                                // Set the colours
                                this._div.classList.remove('alert-info');
                                this._div.classList.remove('alert-success');
                                this._div.classList.remove('alert-warning');
                                this._div.classList.add('alert-danger');
                            }
                        }, 250) // Update every quarter second to stop time from jumping (e.g. 5 -> 4 -> 2 -> 1) due to non-lining up times
                    },

                    handleClicks() { // Handles what happens when you click on a timer
                        this.div.addEventListener('click', () => {
                            if (this.state == 1 || this.state == 2) { // Alarm is counting down or beeping
                                this.sound.pause();
                                this._div.classList.remove('alert-info');
                                this._div.classList.remove('alert-danger');
                                this._div.classList.remove('alert-warning');
                                this._div.classList.add('alert-success');
                                this.state = 3
                            } else if(this.state == 3) { // Beeping has been silenced
                                this._div.remove()
                                timers.splice(timers.indexOf(this.id, 1))
                            }
                        });
                    }
                }

                // Finally, start the timer
                timers[timerID].startTimer()
            }
        })()
    </script>
</span>