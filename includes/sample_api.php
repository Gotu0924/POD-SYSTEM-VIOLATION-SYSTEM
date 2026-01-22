<?php
// API URL
$url = "http://localhost:4000/items"; 

// Fetch data from API
$response = file_get_contents($url);

// Check if response is empty
if ($response === FALSE || empty($response)) {
    die("Error fetching data or empty response");
}

// Decode JSON response
$data = json_decode($response, true);

// Check if JSON decoding worked
if ($data === NULL) {
    die("Error decoding JSON: " . json_last_error_msg());
}

foreach ($data as $id => $item) {
   
    echo '<tr>
    <td>' . $id . '</td>
    <td><img ../assets/src="' . $item['studpic'] . '" width="50" height="50"></td>
    <td>' . $item['name'] . '</td>
    <td>' . $item['studid'] . '</td>
    <td>' . $item['course'] . '</td>
    <td>' . $item['yrlevel'] . '</td>
    <td>
        <div class="btn btn-group">
            <button class="btn btn-success" href="#" onclick="viewStudent(' . $id . ')"><i class="dw dw-eye"></i> View</button>
            <button class="btn btn-warning" onclick="editStudent(' . $id . ')" data-bs-toggle="modal" data-bs-target="#editModal"><i class="dw dw-edit2"></i> Edit</button>
            <button class="btn btn-danger" href="#" onclick="deleteStudent(' . $id . ')"><i class="dw dw-delete-3"></i> Delete</button>
        </div>
    </td>
  </tr>';

}
?>
