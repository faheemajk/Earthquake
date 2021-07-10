<h2>View Data</h2>
<?php
    global $wpdb;
    $id = $_GET['data'];
    $table_name = $wpdb->prefix . 'earth_quake';
    $q = "SELECT * FROM ".$table_name." where file_id=".$id ;
    $result = $wpdb->get_results ( $q);
?>
<table id="example" class="display" style="width:100%">
        <thead>
            <tr>
                <th>time_acc</th>
                <th>acceleration</th>
                <th>acceleration_g</th>
                <th>time_velocity</th>
                <th>velocity</th>
                <th>time_displacement</th>
                <th>displacement</th>
                <th>frequency</th>
                <th>period</th>
                <th>fourier_amplitude</th>
                <th>fourier_phase</th>
                <th>power_amplitude</th>
                <th>time_spectral_displacement</th>
                <th>spectral_displacement</th>
                <th>time_spectral_velocity</th>
                <th>spectral_velocity</th>
                <th>time_spectral_acceleration</th>
                <th>spectral_acceleration</th>
            </tr>
        </thead>
        <tbody>
        <?php
            foreach ( $result as $print )   {
                ?>
                <tr>
                    <td><?= $print->time_acc ?></td>
                    <td><?= $print->acceleration ?></td>
                    <td><?= $print->acceleration_g ?></td>
                    <td><?= $print->time_velocity ?></td>
                    <td><?= $print->velocity ?></td>
                    <td><?= $print->time_displacement ?></td>
                    <td><?= $print->displacement ?></td>
                    <td><?= $print->frequency ?></td>
                    <td><?= $print->period ?></td>
                    <td><?= $print->fourier_amplitude ?></td>
                    <td><?= $print->fourier_phase ?></td>
                    <td><?= $print->power_amplitude ?></td>
                    <td><?= $print->time_spectral_displacement ?></td>
                    <td><?= $print->spectral_displacement ?></td>
                    <td><?= $print->time_spectral_velocity ?></td>
                    <td><?= $print->spectral_velocity ?></td>
                    <td><?= $print->time_spectral_acceleration ?></td>
                    <td><?= $print->spectral_acceleration ?></td>
                </tr>
                    
        <?php } ?>
        </tbody>
        <tfoot>
            <tr>
                <th>time_acc</th>
                <th>acceleration</th>
                <th>acceleration_g</th>
                <th>time_velocity</th>
                <th>velocity</th>
                <th>time_displacement</th>
                <th>displacement</th>
                <th>frequency</th>
                <th>period</th>
                <th>fourier_amplitude</th>
                <th>fourier_phase</th>
                <th>power_amplitude</th>
                <th>time_spectral_displacement</th>
                <th>spectral_displacement</th>
                <th>time_spectral_velocity</th>
                <th>spectral_velocity</th>
                <th>time_spectral_acceleration</th>
                <th>spectral_acceleration</th>
            </tr>
        </tfoot>
    </table>