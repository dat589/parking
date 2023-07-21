<?php
    spl_autoload_register(function ($class) {
        require __DIR__ . "/../../src/$class.php";
    });

    $conn = new Database();
    $vehicle = new Control($conn);

    $month_data = $_POST['month_data'];

    $run = $vehicle->getOutgoing($month_data);

    $count = 1;
    while ($row = $run->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $count; ?></td>
            <td><?php echo $vehicle->viewPlate($row['number_plate']); ?></td>
            <td style="padding-left:45px"><?php echo $row['parking_number']; ?></td>
            <td>
                <a href="view-outgoingvehicle.php?viewId=<?php echo $row['id']; ?>">View</a> | 
                <a href="print.php?vid=<?php echo $row['id']; ?>" style="cursor:pointer" target="_blank">Print</a>
            </td>
        </tr>
    <?php $count ++; }
?>