<?php
// Simple session-based storage instead of passing stored_data via hidden field
    session_start();

    if (!isset($_SESSION['items']) || !is_array($_SESSION['items'])) {
        $_SESSION['items'] = [];
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $_SESSION['items'][] = [
            "item_name" => $_POST["item_name"] ?? "",
            "tech_spec" => $_POST["tech_spec"] ?? "",
            "unit_size" => $_POST["unit_size"] ?? "",
            "category"  => $_POST["category"] ?? ""
        ];

        header("Location: output-form.php");
        exit;
    }

    $items = $_SESSION['items'];  
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Inventory Master Items List</title>

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
    --grey-dark: #383838;
    --grey-line: #D9D9D9;
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
    max-width: 1281px;
    margin: 0 auto;
    padding: 68px 24px 40px;
  }

  .list-card {
    background: var(--navy-panel);
    border-radius: 45px;
    padding: 40px;
  }

  .list-card h2 {
    font-family: 'Bakbak One', sans-serif;
    font-weight: 400;
    font-size: 26px;
    color: var(--cream);
    margin: 0 0 24px;
  }

  .table-wrap {
    background: var(--white);
    border-radius: 25px;
    overflow: hidden;
  }

  table {
    width: 100%;
    border-collapse: collapse;
  }

  thead th {
    background: var(--grey-line);
    font-family: 'Bakbak One', sans-serif;
    font-weight: 400;
    font-size: 16px;
    color: var(--grey-dark);
    text-align: left;
    padding: 20px 24px;
    border-bottom: 2px solid var(--grey-dark);
    border-right: 2px solid var(--grey-dark);
  }

  thead th:last-child { border-right: none; }

  tbody td {
    padding: 18px 24px;
    font-family: Arial, Helvetica, sans-serif;
    font-size: 16px;
    color: var(--grey-dark);
    border-right: 2px solid var(--grey-dark);
    border-bottom: 2px solid var(--grey-dark);
    vertical-align: top;
  }

  tbody td:last-child { border-right: none; }
  tbody tr:last-child td { border-bottom: none; }

  .empty-row td {
    text-align: center;
    padding: 32px 24px;
    color: #777;
    font-family: Arial, Helvetica, sans-serif;
  }

  .table-scroll { overflow-x: auto; }

  .btn-add {
    display: inline-block;
    margin-top: 32px;
    font-family: 'Bakbak One', sans-serif;
    font-size: 18px;
    color: var(--navy-bg);
    background: var(--lime);
    border: none;
    text-decoration: none;
    padding: 15px 34px;
    border-radius: 25px;
    box-shadow: 6px 8px 0 var(--navy-accent);
    cursor: pointer;
    transition: transform 0.15s ease;
  }

  .btn-add:hover { transform: translate(-2px, -2px); }
  .btn-add:focus-visible { outline: 3px solid var(--white); outline-offset: 3px; }

  @media (max-width: 720px) {
    .topbar { padding: 14px 24px; }
    .list-card { padding: 24px; }
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

  <div class="list-card">
    <h2>Inventory Master Items List</h2>

    <div class="table-wrap">
      <div class="table-scroll">
        <table>
          <thead>
            <tr>
              <th>No</th>
              <th>Item Name</th>
              <th>Technical Specifications</th>
              <th>Unit Size</th>
              <th>Category</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($items)): ?>
              <tr class="empty-row">
                <td colspan="5">No items added yet.</td>
              </tr>
            <?php else: ?>
              <?php foreach ($items as $no => $item): ?>
                <tr>
                  <td><?= $no + 1 ?></td>
                  <td><?= htmlspecialchars($item["item_name"]) ?></td>
                  <td><?= htmlspecialchars($item["tech_spec"]) ?></td>
                  <td><?= htmlspecialchars($item["unit_size"]) ?></td>
                  <td><?= htmlspecialchars($item["category"]) ?></td>
                </tr>
              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>

    <form method="POST" action="input-form.php" style="display:inline-block; margin-top:32px;">
      <button type="submit" class="btn-add">Add Another Item</button>
    </form>

  </div>

</main>

</body>
</html>