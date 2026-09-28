<?php
session_start();

if (!isset($_SESSION['items']) || !is_array($_SESSION['items'])) {
    $_SESSION['items'] = [];
}

if (isset($_GET['reset'])) {
    $_SESSION['items'] = [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Input Master Data Barang</title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Bakbak+One&family=Protest+Strike&display=swap" rel="stylesheet">

<style>
  :root {
    --navy-bg: #010736;
    --navy-panel: #0D1C42;
    --navy-accent: #22396F;
    --cream: #FCF1D0;
    --lime: #DEFF69;
    --white: #FFFFFF;
    --muted: #596480;
  }

  * { box-sizing: border-box; }

  body {
    margin: 0;
    background: var(--navy-bg);
    font-family: 'Bakbak One', sans-serif;
  }

  .topbar {
    background: var(--cream);
    min-height: 109px;
    display: flex;
    align-items: center;
    padding: 14px 48px;
  }

  .logo { display: flex; align-items: center; gap: 14px; }

  .logo-mark { flex-shrink: 0; display: block; }

  .logo-caption {
    font-family: 'Protest Strike', sans-serif;
    font-size: 24px;
    line-height: 1.3;
    color: var(--navy-accent);
  }

  .content {
    max-width: 1320px;
    margin: 0 auto;
    padding: 80px 40px;
    display: flex;
    flex-wrap: wrap;
    gap: 56px;
    align-items: flex-start;
    justify-content: center;
  }

  .intro {
    display: flex;
    gap: 22px;
    flex: 1 1 420px;
    max-width: 540px;
    padding-top: 24px;
  }

  .accent-bar {
    width: 8px;
    border-radius: 4px;
    background: var(--cream);
    align-self: stretch;
    flex-shrink: 0;
  }

  .intro h1 {
    font-family: 'Protest Strike', sans-serif;
    font-weight: 400;
    font-size: clamp(38px, 5vw, 64px);
    line-height: 1.18;
    color: var(--cream);
    margin: 0;
  }

  .form-card {
    background: var(--navy-panel);
    border-radius: 45px;
    padding: 48px 44px;
    width: 100%;
    max-width: 657px;
  }

  .field { margin-bottom: 30px; }

  .field label {
    display: block;
    font-family: 'Bakbak One', sans-serif;
    font-size: 20px;
    color: var(--cream);
    margin-bottom: 12px;
  }

  .field input,
  .field select,
  .field textarea {
    width: 100%;
    border: none;
    border-radius: 25px;
    background: var(--white);
    padding: 19px 26px;
    font-family: 'Bakbak One', sans-serif;
    font-size: 20px;
    color: var(--navy-accent);
    box-shadow: 8px 8px 0 var(--navy-accent);
    appearance: none;
    -webkit-appearance: none;
  }

  .field textarea {
    resize: vertical;
    min-height: 110px;
    font-family: Arial, Helvetica, sans-serif;
    line-height: 1.4;
  }

  .field select {
    color: var(--muted);
    background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='16' height='10'><path d='M1 1l7 7 7-7' stroke='%23596480' stroke-width='2' fill='none' stroke-linecap='round' stroke-linejoin='round'/></svg>");
    background-repeat: no-repeat;
    background-position: right 26px center;
    padding-right: 56px;
  }

  .field input::placeholder,
  .field textarea::placeholder {
    color: var(--muted);
    opacity: 1;
  }

  .field input:focus,
  .field select:focus,
  .field textarea:focus {
    outline: 3px solid var(--lime);
    outline-offset: 2px;
  }

  .actions {
    display: flex;
    justify-content: flex-end;
    margin-top: 14px;
  }

  .btn-save {
    font-family: 'Bakbak One', sans-serif;
    font-size: 22px;
    color: var(--navy-bg);
    background: var(--lime);
    border: none;
    border-radius: 25px;
    padding: 16px 46px;
    box-shadow: 6px 8px 0 var(--navy-accent);
    cursor: pointer;
    transition: transform 0.15s ease;
  }

  .btn-save:hover { transform: translate(-2px, -2px); }
  .btn-save:focus-visible { outline: 3px solid var(--white); outline-offset: 3px; }

  @media (max-width: 720px) {
    .topbar { padding: 14px 24px; }
    .content { padding: 48px 20px; }
    .form-card { padding: 32px 24px; }
  }
</style>
</head>

<body>

<header class="topbar">
  <div class="logo">
    <svg class="logo-mark" width="89" height="47" viewBox="0 0 105 56" fill="none" xmlns="http://www.w3.org/2000/svg">
      <path d="M77.5117 42.7168C80.0625 42.7168 81.9756 42.4401 83.251 41.8866C84.5264 41.3332 85.1641 40.4275 85.1641 39.1697C85.1641 38.3143 84.862 37.6351 84.2579 37.1319C83.6538 36.6288 82.5797 36.1257 81.0358 35.6225L70.3627 31.9244C66.4022 30.5659 63.3479 28.7546 61.1999 26.4905C59.0518 24.2263 57.9778 20.9307 57.9778 16.6037C57.9778 11.0691 59.8909 6.94337 63.7171 4.2264C67.6105 1.45911 74.0211 0.0503136 82.9489 0C86.6409 0 89.9972 0.125785 93.0179 0.377356C96.0386 0.628927 98.4552 0.905657 100.268 1.20754C102.08 1.45912 102.986 1.5849 102.986 1.5849L100.972 13.7358C100.972 13.7358 100.133 13.6603 98.4552 13.5094C96.8442 13.3584 94.8304 13.2327 92.4138 13.132C89.9972 12.9811 87.6478 12.9056 85.3655 12.9056C82.9489 12.9056 81.1029 13.1823 79.8275 13.7358C78.6193 14.2389 78.0151 15.2201 78.0151 16.6792C78.0151 17.4842 78.485 18.1635 79.4248 18.7169C80.3646 19.2201 81.6735 19.7484 83.3517 20.3018L91.9103 23.0943C96.475 24.6037 99.7977 26.4905 101.879 28.7546C103.96 30.9684 105 34.1382 105 38.264C105 43.8489 103.053 48.1508 99.16 51.1696C95.2667 54.1885 88.8561 55.7231 79.9282 55.7734C75.4979 55.7734 71.3696 55.547 67.5433 55.0942C63.7171 54.6916 60.3272 54.2136 57.3737 53.6602L59.3875 41.5093C59.3875 41.5093 60.193 41.6099 61.804 41.8112C63.4822 42.0124 65.6974 42.2137 68.4496 42.4149C71.2018 42.6162 74.2225 42.7168 77.5117 42.7168Z" fill="#22396F"/>
      <path d="M50.3092 53.1353V55.0191H30.6754V48.8365L50.3092 53.1353ZM50.3092 42.274V50.0689L30.6754 45.7701V39.9546L50.3092 42.274ZM50.3092 40.2622L30.6754 37.9429V0.67923H50.3092V40.2622Z" fill="#22396F"/>
      <path d="M19.6348 46.42V55.1514H0V42.1212L19.6348 46.42ZM19.6348 38.6495V43.3536L0 39.0547V36.3292L19.6348 38.6495ZM19.6348 36.6387L0 34.3184V0.811584H19.6348V36.6387Z" fill="#22396F"/>
    </svg>
    <div class="logo-caption">Inventory<br>Information Systems</div>
  </div>
</header>

<main class="content">

  <div class="intro">
    <span class="accent-bar" aria-hidden="true"></span>
    <h1>Item Catalog Master Data</h1>
  </div>

  <div class="form-card">
    <form method="POST" action="output-form.php">

      <div class="field">
        <label for="item_name">Item Name</label>
        <input type="text" id="item_name" name="item_name" required>
      </div>

      <div class="field">
        <label for="tech_spec">Technical Specifications</label>
        <textarea id="tech_spec" name="tech_spec" rows="3"></textarea>
      </div>

      <div class="field">
        <label for="unit_size">Unit Size</label>
        <input type="text" id="unit_size" name="unit_size" placeholder="e.g. 10cm x 20cm">
      </div>

      <div class="field">
        <label for="category">Category</label>
        <select id="category" name="category" required>
          <option value="" disabled selected>Select Category</option>
          <option value="Electronics">Electronics</option>
          <option value="Mechanical Parts">Mechanical Parts</option>
          <option value="Raw Materials">Raw Materials</option>
          <option value="Consumables">Consumables</option>
          <option value="Packaging">Packaging</option>
        </select>
      </div>

      <div class="actions">
        <button type="submit" class="btn-save">SAVE</button>
      </div>

    </form>
  </div>

</main>

</body>
</html>z
