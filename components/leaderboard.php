<!-- ***** Podium Area Start ***** -->
<section id="leaderboard" class="wallet-connect-area pb-0">
    <div class="container">
        <h2 class="text-center">The Leaderboard</h2>
        <div id="podium-body" class="row justify-content-center items">
        </div>
    </div>
    <div class="leaderboard-area container pt-5">
        <!--<h2 class="text-center">The other seven</h2>-->
        <div class="row justify-content-between">
            <div class="col-12">
                <div class="table-responsive">
                    <table id="other-seven-leaderboard" class="table token-content table-borderless">
                        <thead>
                            <tr>
                                <th scope="col"># Rank</th>
                                <th scope="col">Name</th>
                                <th scope="col"># Wins</th>
                                <th scope="col">Last time online</th>
                            </tr>
                        </thead>
                        <tbody id="leaderboard-body"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ***** Podium Area End ***** -->
<script>
    const userLocale = navigator.language || navigator.languages[0];
    const formatter = new Intl.DateTimeFormat(userLocale, {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit'
    });

    function getLeaderboard() {
        fetch('php/get_leaderboard.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {

                    const trophyColors = ["gold", "silver", "bronze"];
                    const orders = [2, 1, 3]; // For desktop
                    const mobileOrders = [1, 2, 3] // For mobile
                    const podiumMessages = ["The number one contender", "The best second player", "The best third player"];

                    const leaderboard = data.data;
                    const tbody = document.getElementById('leaderboard-body');
                    let rows = '';

                    const podium = document.getElementById('podium-body');
                    let podiumData = '';

                    leaderboard.forEach((entry, index) => {
                        if (index < 3) {
                            podiumData += `
                                <div class="col-12 col-md-6 col-lg-4 item order-xl-${orders[index]} order-md-${orders[index]} order-sm-${mobileOrders[index]} order-${mobileOrders[index]} ${orders[index] != 2 ? 'pt-lg-5' : ''}">
                                    <!-- Single Wallet -->
                                    <div class="card project-card single-wallet">
                                        <div class="d-block text-center justify-content-center">
                                            <i class="icon ${index == 0 ? 'icon-trophy' : 'icon-badge'}  mb-3 ${trophyColors[index]}"></i>
                                        </div>
                                        <div class="d-block text-center justify-content-center">
                                            <img class="" src="https://api.mineatar.io/body/full/${entry.uuid}?scale=7" alt="${entry.name}">
                                            <h4 class="mb-1"> ${index + 1}. ${entry.name}</h4>
                                            <div class="single-item">
                                                <span>${podiumMessages[index]}</span>
                                                <span>with ${entry.wins_count} wins</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                `;
                        }
                        if (index >= 3) {
                            rows += `
                                <tr>
                                    <td>${index + 1}.</td>
                                    <td><img class="mr-2" src="https://api.mineatar.io/face/${entry.uuid}?scale=3" alt="${entry.name}">${entry.name}</td>
                                     <td>${entry.wins_count}</td>
                                    <td>${formatter.format(new Date(entry.last_time_online))}</td>
                                </tr>`;
                        }

                    });

                    podium.innerHTML = podiumData;

                    if (leaderboard.length > 3) {
                        $('#other-seven-leaderboard').show();
                        tbody.innerHTML = rows;
                    } else {
                        $('#other-seven-leaderboard').hide();
                    }

                } else {
                    alert("Error: " + data.message + ". Contact rutiglianoalberto97@gmail.com or xxx");
                }
            })
            .catch((error) => {
                console.error('Error:', error);
            });
    }
    getLeaderboard();
</script>