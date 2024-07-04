  <!--====== Modal Search Area Start ======-->
  <div id="premium-modal" class="modal fade p-0">
      <div class="modal-dialog dialog-animated">
          <div class="modal-content h-100">
              <div class="modal-header" data-dismiss="modal">
                  Premium <i class="far fa-times-circle icon-close"></i>
              </div>
              <div class="modal-body">
                  <div class="row">
                      <div class="col-12 align-self-center">
                          <div class="row ">
                              <div class="col-12 pb-3">
                                  <h2 class="search-title mt-0 mb-3">Hi!</h2>
                                  <p>Insert your Minecraft username here and let's recognize you by the skin!</p>
                              </div>

                              <div class="col-12 input-box mt-md-2 staking-area">
                                  <div class="input-area d-flex flex-column flex-md-row mb-3">
                                      <div class="input-text">
                                          <input id="username" name="username" type="text" placeholder="Enter your Minecraft username">
                                      </div>
                                      <button class="btn btn-bordered-white mt-2 mt-md-0 ml-md-3" onclick="premiumModal(document.getElementById('username').value); return false;">
                                          <i class="icon-magnifier"></i></button>
                                  </div>
                              </div>
                              <div class="col-12">
                                  <div id="loading" class="spinner-border" role="status">
                                      <span class="sr-only">Loading...</span>
                                  </div>
                                  <div id="user-found" class="card team-card text-center">
                                      <a class="team-photo d-inline-block" href="leaderboard.html">
                                          <img id="premium-user-avatar" class="mx-auto" src="https://api.mineatar.io/face/e4037bdba11745d3a578fc51bc12d807?scale=32" alt="">
                                      </a>
                                      <!-- Team Content -->
                                      <div class="team-content mt-3">
                                          <a href="leaderboard.html">
                                              <h4 id="premium-user-name" class="mb-0">{{username}}</h4>
                                          </a>
                                          <span class="d-inline-block mt-2 mb-3">Yes! We found you!</span>
                                      </div>
                                  </div>
                                  <div id="user-not-found" class="card team-card text-center">
                                      <!-- Team Content -->
                                      <div class="team-content mt-3">
                                          <span id="user-not-found-message" class="d-inline-block mt-2 mb-3 text-danger">errorMessage</span>
                                      </div>
                                  </div>
                              </div>
                              <div class="col-12 pt-2">
                                  <button id="get-premium" name="get-premium" class="btn btn-block mt-2 mt-md-0"></button>
                              </div>
                          </div>

                      </div>
                  </div>
              </div>
          </div>
      </div>
      <!--====== Modal Search Area End ======-->
      <script>
          const params = new Proxy(new URLSearchParams(window.location.search), {
              get: (searchParams, prop) => searchParams.get(prop),
          });
          let username = params.username;
          let uuid = params.uuid;

          $('#user-found').hide();
          $('#user-not-found').hide();
          $('#get-premium').hide();
          $('#loading').hide();

          function premiumModal(input) {
              if (input != null) {
                  $('#loading').show();
                  $('#user-found').hide();
                  $('#user-not-found').hide();
                  $('#get-premium').hide();
                  //var url = "https://api.mojang.com/users/profiles/minecraft/" + input;
                  var url = `php/proxy.php?input=${input}`;

                  fetch(url, {
                          method: 'GET',
                          headers: {
                              'Content-Type': 'application/json',
                          }
                      })
                      .then(response => {
                          $('#loading').hide();
                          if (!response.ok) {
                              $('#user-found').hide();
                              $('#user-not-found').show();
                              $('#user-not-found-message').text(input + " user not found");
                              throw new Error('Network response was not ok: ' + response.statusText);
                          }
                          return response.json();
                      })
                      .then(data => {
                          if (data.name && data.id) {
                              $('#user-found').show();
                              $('#user-not-found').hide();
                              $("#premium-user-avatar").attr("src", "https://api.mineatar.io/face/" + data.id + "?scale=32");
                              $("#premium-cta-avatar").attr("src", "https://api.mineatar.io/face/" + data.id + "?scale=32");
                              $('#premium-user-name').html(data.name);
                              $('#username').val(data.name);
                              handlePaypalDonation();
                          } else {
                              $('#user-found').hide();
                              $('#user-not-found').show();
                              $('#user-not-found-message').text(input + " user not found");
                          }

                      })
                      .catch((error) => {
                          console.error('Error:', error);
                      });
              } else {
                  $('#user-found').hide();
                  $('#user-not-found').hide();
              }
          }

          // Function to handle the PayPal donation process
          function handlePaypalDonation() {
              $('#get-premium').show();
              $('#donate-button').remove();
              const uuidInput = document.getElementById('username').value;
              PayPal.Donation.Button({
                  env: 'sandbox',
                  hosted_button_id: 'V3PS3AQKVYTMA',
                  image: {
                      src: '#',
                      title: 'PayPal - The safer, easier way to pay online!',
                      alt: 'Claim your premium now!'
                  },
                  item_name: uuidInput,
                  onComplete: function(params) {
                      fetch('update_premium.php', {
                              method: 'POST',
                              headers: {
                                  'Content-Type': 'application/json',
                              },
                              body: JSON.stringify({
                                  uuid: uuidInput
                              }),
                          })
                          .then(response => response.json())
                          .then(data => {
                              if (data.status === 'success') {
                                  alert("Database updated successfully!");
                              } else {
                                  alert("Error: " + data.message + ". Contact rutiglianoalberto97@gmail.com or xxx");
                              }
                          })
                          .catch((error) => {
                              console.error('Error:', error);
                          });
                  },
              }).render('#get-premium');

          }

          // Attach an event listener to the PayPal button container to initialize the donation process
          //document.getElementById('get-premium').addEventListener('click', handlePaypalDonation);
          document.getElementById('get-premium').addEventListener('click', function() {
              event.preventDefault();
              handlePaypalDonation;
          });

          if (uuid != null) {
              premiumModal(uuid);
          } else {
              premiumModal(username);
          }
      </script>