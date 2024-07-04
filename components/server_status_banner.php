<!-- ***** Item Details Area Start ***** -->
<section id="status" class="item-details-area pb-0">
    <div class="container">
        <h2 class="text-center">Server Status</h2>
        <div class="row justify-content-between">
            <div class="col-12">
                <!-- Project Card -->
                <div class="card project-card no-hover">
                    <div class="media">
                        <img id="icon" name="icon" class="card-img-top avatar-max-lg" src="assets/img/server-icon-96.png" alt="">
                        <div class="media-body ml-4">
                            <h4 class="m-0">LAR Hunger Games</h4>
                            <div class="countdown-times">
                                <h6 id="online-status" class="server-status my-2">Pinging...</h6>
                                <!--<div class="countdown d-flex" data-date="2024-06-30"></div>-->
                                <h6 id="current-phase" class="my-2"></h6>
                            </div>
                        </div>
                    </div>
                    <!-- Project Body -->
                    <div id="other-server-info" class="card-body">

                        <div class="items">
                            <!-- Single Item -->
                            <div class="single-item">
                                <span>Last game finished at</span>
                                <span id="last-win-datetime">xxx</span>
                            </div>
                            <!-- Single Item -->
                            <div class="single-item">
                                <span>The reigning winner is</span>
                                <span id="winner-name">xxx</span>
                            </div>
                            <!-- Single Item -->
                            <div class="single-item">
                                <span>Current Minecraft version is</span>
                                <span id="minecraft-version">xxx</span>
                            </div>
                        </div>
                        <div class="item-progress">
                            <div class="progress mt-4 mt-md-5">
                                <div id="players-progress-bar" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 40%;" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div class="progress-sale d-flex justify-content-between mt-3">
                                <span id="players-num"></span>
                                <span id="max-players-num"></span>
                            </div>
                        </div>
                    </div>
                    <!-- Blockchain Icon -->
                    <div class="blockchain-icon pt-4 pt-lg-0">
                        <a class="d-block text-center justify-content-center btn btn-bordered-white" href="#" id="address" name="address" data-toggle="tooltip" data-placement="top" html=true title="<i class='icon-tag mr-1'></i> Click or tap to copy"><i class="icon-tag mr-2"></i>127.0.0.1:8080</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ***** Item Details Area End ***** -->
<script>
    $(document).ready(function(){
            $('#address').tooltip({
                html: true
            });
        });
    document.getElementById('address').innerHTML = server.ip + ":" + server.port;
    $('#other-server-info').hide();
    const formdata = new FormData();
    formdata.append("serverId", server.multicraftId);
    formdata.append("apiUser", "api");
    formdata.append("apiPassword", "FM+ae5HGsKiw63");
    formdata.append("command", "getServerStatus");

    function getServerInfo() {
        fetch("http://" + server.ip + "/multicraft/serverapi.php", {
                //fetch("http://" + server.ip + "/multicraft/getServerStatus.php?_=" + new Date().getTime(), {
                method: 'POST',
                body: formdata,
                redirect: "follow",
                cache: 'no-store',
                headers: {
                    'Cache-Control': 'no-cache'
                }
            })
            .then(response => {
                console.log('Response:', response);
                if (!response.ok) {
                    throw new Error('Network response was not ok: ' + response.statusText);
                }
                return response.json();
            })
            .then(data => {
                document.getElementById('address').innerHTML = server.ip + ":" + server.port;
                if (data.data.status == 'online') {
                    $('#other-server-info').show();
                    document.getElementById('online-status').className = 'server-status my-2 text-success';
                    document.getElementById('online-status').innerHTML = '<i class="icon-globe mr-1"></i> Online';
                    //document.getElementById('icon').src = data.icon;
                    var percentagePlayers = (data.data.onlinePlayers * 100) / data.data.maxPlayers;
                    if (data.data.onlinePlayers == 0) {
                        document.getElementById('players-num').innerHTML = 'No online players'
                    } else {
                        document.getElementById('players-num').innerHTML = data.data.onlinePlayers + ' online players';
                    }

                    document.getElementById('max-players-num').innerHTML = 'Server capacity: Up to ' + data.data.maxPlayers + ' players';

                    $("#players-progress-bar").removeClass();
                    $("#players-progress-bar").addClass("progress-bar");
                    if (percentagePlayers > 0) {
                        document.getElementById('players-progress-bar').ariaValueNow = percentagePlayers;
                        document.getElementById('players-progress-bar').style = 'width: ' + percentagePlayers + '%';
                    } else {
                        document.getElementById('players-progress-bar').ariaValueNow = 1;
                        document.getElementById('players-progress-bar').style = 'width: 1%';
                    }

                    $('#minecraft-version').text(server.version);
                    getHungerGamesInfo(data.data.status == 'online');

                } else {
                    $('#other-server-info').hide();
                    document.getElementById('online-status').className = 'server-status my-2 text-danger';
                    document.getElementById('online-status').innerHTML = '<i class="icon-globe-alt mr-1"></i> Offline';
                }

            })
            .catch((error) => {
                console.error('Error:', error);
            });
    }

    setInterval(function() {
        getServerInfo();
    }, 5000); // 10000 milliseconds = 10 seconds


    var myArray = {
        WAITING: "Waiting for the minimum number of players to start the game",
        LOBBY: "Game is starting. Users can still enter for the current game",
        SAFE_AREA: "Playing phase. You can enter as a spectator to watch the game",
        PLAYING: "Playing phase. You can enter as a spectator to watch the game",
        WINNING: "Hunger Games match is ending. Server will be restarted soon",
        ENDED: "Match finished! Server will be restarted soon"
    };

    function getHungerGamesInfo(isOnline) {
        fetch('php/get_hunger_games_info.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    const hgInfo = data.data;
                    const userLocale = navigator.language || navigator.languages[0];
                    const formatter = new Intl.DateTimeFormat(userLocale, {
                        day: '2-digit',
                        month: '2-digit',
                        year: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit',
                        second: '2-digit'
                    });
                    $('#last-win-datetime').text(formatter.format(new Date(hgInfo.win_datetime)));
                    $('#winner-name').text(hgInfo.winner_name);
                    if (isOnline) {
                        $('#current-phase').text(myArray[hgInfo.current_phase]);
                    }
                }
            })
            .catch((error) => {
                console.error('Error:', error);
            });
    }


    function tooltip() {
        document.getElementById('address').addEventListener('click', function() {
            event.preventDefault();
            var textToCopy = server.ip + ":" + server.port;
            navigator.clipboard.writeText(textToCopy).then(function() {
                $('#address').attr('title', '<i class="icon-check mr-1"></i> Copied!');
                $('#address').tooltip('dispose').tooltip({
                    html: true,
                    title: "<i class='icon-check mr-1'></i> Copied!"
                }).tooltip('show');
                // Change the text back after 10 seconds
                setTimeout(function() {
                    $('#address').attr('title', '<i class="icon-tag mr-1"></i> Click or tap to copy');
                $('#address').tooltip('dispose').tooltip({
                    html: true,
                    title: "<i class='icon-tag mr-1'></i> Click or tap to copy"
                }).tooltip('hide');
                }, 5000); // 10000 milliseconds = 10 seconds
            }).catch(function(error) {
                alert('Failed to copy text: ', error);
            });
        });
    }
    tooltip();
</script>