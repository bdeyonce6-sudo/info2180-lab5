<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

// An empty search becomes LIKE '%%', which matches every country.
$country = trim($_GET['country'] ?? '');
$lookup = $_GET['lookup'] ?? '';

if ($lookup === 'cities') {
    $stmt = $conn->prepare(
        "SELECT cities.name, cities.district, cities.population
         FROM cities
         JOIN countries ON cities.country_code = countries.code
         WHERE countries.name LIKE :country
         ORDER BY cities.population DESC"
    );
} else {
    $stmt = $conn->prepare("SELECT * FROM countries WHERE name LIKE :country");
}

// The search text is bound as a parameter so it can't change the SQL.
$stmt->execute(['country' => "%$country%"]);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Makes database values safe to print in HTML. Some columns can be NULL.
function e($value) {
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}
?>
<?php if ($lookup === 'cities'): ?>
<table>
  <thead>
    <tr>
      <th>Name</th>
      <th>District</th>
      <th>Population</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($results as $row): ?>
    <tr>
      <td><?= e($row['name']); ?></td>
      <td><?= e($row['district']); ?></td>
      <td><?= e($row['population']); ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<?php else: ?>
<table>
  <thead>
    <tr>
      <th>Country Name</th>
      <th>Continent</th>
      <th>Independence Year</th>
      <th>Head of State</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($results as $row): ?>
    <tr>
      <td><?= e($row['name']); ?></td>
      <td><?= e($row['continent']); ?></td>
      <td><?= e($row['independence_year']); ?></td>
      <td><?= e($row['head_of_state']); ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<?php endif; ?>
