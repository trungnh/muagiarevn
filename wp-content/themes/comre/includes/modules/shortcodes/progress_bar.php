<?php ob_start(); ?>


  <div class="col-md-6">
          <div class="tittle">
            <h3 class="text-left">progress bar style </h3>
          </div>
          <!--======= PROGRESS BAR =========-->
          <div class="skills-bar">
            <ul>
              <!--======= PHOTOSHOP =========-->
              <li>
                <h5>graphic design</h5>
                <div class="progress">
                  <div class="progress-bar" role="progressbar" aria-valuenow="95" aria-valuemin="0" aria-valuemax="100" style="width: 95%;"> <span>95%</span> </div>
                </div>
              </li>
              
              <!--======= HTML5 / CSS3 =========-->
              <li>
                <h5>HTML5 / CSS3</h5>
                <div class="progress">
                  <div class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width: 70%;"> <span>70%</span> </div>
                </div>
              </li>
              
              <!--======= DREAMWEAVER =========-->
              <li>
                <h5>DREAMWEAVER</h5>
                <div class="progress">
                  <div class="progress-bar" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%;"> <span>80%</span> </div>
                </div>
              </li>
            </ul>
          </div>
        </div>

<?php return ob_get_clean();