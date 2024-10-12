<?php
include "shared/header.php";
include "shared/config.php";
?>

<nav class="bread-crumbs">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <ul class="bread-crumbs-list">
          <li>
            <a href="index.html">Home</a>
            <i class="material-icons md-18">chevron_right</i>
          </li>
          <li>Pre-Build PCs</li>
        </ul>
      </div>
    </div>
  </div>
</nav>

<!-- Loading Bar -->
<div id="loading-bar" style="display: none;">
  <div class="progress">
    <div class="progress-bar" role="progressbar" style="width: 0%;" id="progress-bar"></div>
  </div>
</div>

<div class="section">
  <div class="container">
    <div class="row items">
      <header class="col-12">
        <div class="section-heading heading-center">
          <div class="section-subheading">Following are some Pre-Build PCs</div>
          <h1>Pre-Build PCs</h1>
        </div>
      </header>

      <!-- Price Range Filter Bar -->
      <div class="col-12 mb-4">
        <label for="price-range">Price Range:</label>
        <input type="range" class="form-range" id="price-range" name="price_range" min="0" max="20000" step="100" value="1000">
        <input type="number" id="price-input" min="0" max="20000" step="100" value="1000" style="margin-left: 10px; width: 100px;">
      </div>

      <!-- PC Cards Container -->
      <div class="col-12" id="pc-cards">
        <div class="row">
          <?php
          $sql = "SELECT * FROM `pre_build`";
          $result = mysqli_query($conn, $sql);

          while ($rows = mysqli_fetch_array($result)) {
          ?>
            <div class="col-md-4 mb-4 pc-card">
              <div class="card h-100">
                <img src="../AdminPanel/compimg/<?php echo $rows['final_img'] ?>" height="100%" class="card-img-top" alt="Gaming PC with black ATX mid-tower case and tempered glass side panel">
                <div class="card-body">
                  <h5 class="card-title"><?php echo $rows['build_name'] ?></h5>
                  <h6 class="card-title">Price: $<?php echo $rows['price'] ?></h6>
                  <p class="card-text"><?php echo $rows['short_desc'] ?>...</p>
                  <a href="prebuildshow.php?id=<?php echo $rows['pre_id']; ?>" class="btn btn-border btn-with-icon btn-small ripple">
                    <span>Details</span>
                    <svg class="btn-icon-right" viewBox="0 0 13 9" width="13" height="9">
                      <use xlink:href="assets/img/sprite.svg#arrow-right"></use>
                    </svg>
                  </a>
                </div>
              </div>
            </div>
          <?php
          }
          ?>
        </div>
      </div>
      <!-- No PC Message -->
      <div class="col-12">
  <div id="no-pc-message" class="alert alert-warning text-center" role="alert" style="display: none;">
    Sorry, we don't have any PC under your budget.
  </div>
</div>
    </div>
  </div>
</div>

<script>
  var priceRange = document.getElementById('price-range');
  var priceInput = document.getElementById('price-input');
  var filterTimeout;
  var loadingBar = document.getElementById('loading-bar');
  var progressBar = document.getElementById('progress-bar');

  function filterPCs(price) {
    var pcCards = document.getElementsByClassName('pc-card');
    var noPcMessage = document.getElementById('no-pc-message');
    var foundPC = false;

    for (var i = 0; i < pcCards.length; i++) {
      var cardPrice = parseFloat(pcCards[i].querySelector('.card-title + .card-title').textContent.replace('Price: $', ''));
      
      // Show cards within range of 20% of selected price
      if (cardPrice >= price * 0.8 && cardPrice <= price * 1.2) {
        pcCards[i].style.display = 'block';
        foundPC = true;
      } else {
        pcCards[i].style.display = 'none';
      }
    }

    // Show message if no PCs found under budget
    if (!foundPC) {
      noPcMessage.style.display = 'block';
    } else {
      noPcMessage.style.display = 'none';
    }

    // Hide loading bar
    loadingBar.style.display = 'none';
  }

  function updatePriceValue(price) {
    priceRange.value = price;
    priceInput.value = price;
  }

  priceRange.addEventListener('input', function() {
    clearTimeout(filterTimeout);
    var price = parseFloat(priceRange.value);
    updatePriceValue(price);

    // Show loading bar
    loadingBar.style.display = 'block';
    progressBar.style.width = '0%';

    // Progress bar animation
    var progress = 0;
    var interval = setInterval(function() {
      progress += 10;
      progressBar.style.width = progress + '%';
      if (progress >= 100) {
        clearInterval(interval);
      }
    }, 100); // Update every 100ms to complete in 1 second

    filterTimeout = setTimeout(function() {
      filterPCs(price);
    }, 1000); // 1 second delay
  });

  priceInput.addEventListener('input', function() {
    clearTimeout(filterTimeout);
    var price = parseFloat(priceInput.value);
    updatePriceValue(price);

    // Show loading bar
    loadingBar.style.display = 'block';
    progressBar.style.width = '0%';

    // Progress bar animation
    var progress = 0;
    var interval = setInterval(function() {
      progress += 10;
      progressBar.style.width = progress + '%';
      if (progress >= 100) {
        clearInterval(interval);
      }
    }, 100); // Update every 100ms to complete in 1 second

    filterTimeout = setTimeout(function() {
      filterPCs(price);
    }, 1000); // 1 second delay
  });

  // Initial display of all PCs
  var pcCards = document.getElementsByClassName('pc-card');
  for (var i = 0; i < pcCards.length; i++) {
    pcCards[i].style.display = 'block';
  }
</script>
<br><br><br><br>
<br><br><br>
<?php
include "shared/footer.php";
?>

<style>
  .form-range {
    padding-top: 1.2%;
    width: 200px; /* Adjust the width as per your design */
  }
  .progress {
    height: 10px;
  }
  .progress-bar {
    background-color: #007bff;
    transition: width 0.2s;
  }
  #loading-bar {
    position: fixed;
    width: 100%;
    top: 0;
    z-index: 9999;
  }
  #price-input{
    margin-left: 10px;
    width: 100px;
    float: inline-end;
  }
</style>
