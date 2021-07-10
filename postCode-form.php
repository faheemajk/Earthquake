<h4>Upload File</h4>
<form class="form-inline" id="EARTHQUAKE_upload" action="<?= esc_url( admin_url('admin-post.php') ); ?>" enctype="multipart/form-data" method="post">
    <input type="hidden" name="action" value="my_simple_form">
    <?= ($edit_data != '') ? '<input type="hidden" name="edit_form_save" value="'.$edit_data->id.'">' : ''; ?>
    <div class="row">
        <div class="col-lg-2">
            <input type="text" class="form-control" name="data_datetime" value="<?= ($edit_data != '') ? $edit_data->data_datetime : ''; ?>" id='datetimepicker1' placeholder="Date & Time">
        </div>
        <div class="col-lg-2">
            <input type="number" class="form-control" name="magnitude" value="<?= ($edit_data != '') ? $edit_data->magnitude : ''; ?>" step="any" placeholder="Magnitude">
        </div>
        <div class="col-lg-2">
            <input type="number" class="form-control" name="latitide" value="<?= ($edit_data != '') ? $edit_data->latitide : ''; ?>" step="0.000000001" placeholder="Latitude" required>
        </div>
        <div class="col-lg-2">
            <input type="number" class="form-control" name="longitude" value="<?= ($edit_data != '') ? $edit_data->longitude : ''; ?>" step="0.000000001" placeholder="Longitude" required>
        </div>
        <div class="col-lg-2">
            <input type="number" class="form-control" name="depth" value="<?= ($edit_data != '') ? $edit_data->depth : ''; ?>" step="0.000000001" placeholder="Depth">
        </div>
        
    </div>
    <div class="row">
        <div class="col-lg-2">
            <input type="text" class="form-control" name="region" value="<?= ($edit_data != '') ? $edit_data->region : ''; ?>" placeholder="Region">
        </div>
        <div class="col-lg-2">
            <input type="text" class="form-control" name="network" value="<?= ($edit_data != '') ? $edit_data->network : ''; ?>" placeholder="Network">
        </div>
        <div class="col-lg-2">
            <input type="text" class="form-control" name="station" value="<?= ($edit_data != '') ? $edit_data->station : ''; ?>" placeholder="Station">
        </div>
        <div class="col-lg-2">
            <input type="text" class="form-control" name="station_name" value="<?= ($edit_data != '') ? $edit_data->station_name : ''; ?>" placeholder="Station Name">
        </div>
        <div class="col-lg-2">
            <input type="text" class="form-control" name="channel" value="<?= ($edit_data != '') ? $edit_data->channel : ''; ?>" placeholder="Channel">
        </div>
        
    </div>
    <div class="row">
        <div class="col-lg-2">
            <input type="text" class="form-control"name="location" value="<?= ($edit_data != '') ? $edit_data->location : ''; ?>" placeholder="Location">
        </div>
        <div class="col-lg-2">
            <input type="number" class="form-control" name="loc_latitude" value="<?= ($edit_data != '') ? $edit_data->loc_latitude : ''; ?>" step="0.000000001" placeholder="Latitude">
        </div>
        <div class="col-lg-2">
            <input type="number" class="form-control" name="loc_longitude" value="<?= ($edit_data != '') ? $edit_data->loc_longitude : ''; ?>" step="0.000000001" placeholder="Longitude">
        </div>
        <div class="col-lg-2">
            <input type="number" class="form-control" name="scale" value="<?= ($edit_data != '') ? $edit_data->scale : ''; ?>" placeholder="Scale">
        </div>
        <div class="col-lg-2">
            <input type="number" class="form-control" name="distance_deg" value="<?= ($edit_data != '') ? $edit_data->distance_deg : ''; ?>" step="0.000000001" placeholder="Distance Degree">
        </div>
        
    </div>
    
    <div class="row">
        <div class="col-lg-2">
            <input type="number" class="form-control" name="distance_km" value="<?= ($edit_data != '') ? $edit_data->distance_km : ''; ?>" step="0.000000001" placeholder="Distance Km">
        </div>
        <div class="col-lg-2">
            <input type="text" class="form-control" name="start_time"  value="<?= ($edit_data != '') ? $edit_data->start_time : ''; ?>" placeholder="Start Time">
        </div>
        <div class="col-lg-2">
            <input type="text" class="form-control" name="end_time" value="<?= ($edit_data != '') ? $edit_data->end_time : ''; ?>" placeholder="End Time">
        </div>
        <div class="col-lg-2">
            <input type="file"  class="form-control" name="fileToUpload" id="fileToUpload"  accept=".csv" <?= ($edit_data != '') ? '' : 'required'; ?>>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12"> 
            <b>Parameters</b>
        </div>
        <div class="col-md-12"> 
            <textarea name="gm_parameters"><?= ($edit_data != '') ? $edit_data->gm_parameters : ''; ?></textarea>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12"> 
            <b>Event Overview</b>
        </div>
        <div class="col-md-12"> 
            <textarea name="event_overview"><?= ($edit_data != '') ? $edit_data->event_overview : ''; ?></textarea>
        </div>
    </div> 
    <div class="row"> 
        <div class="col-md-12">      
            <input type="submit" name="submit" class="btn btn-primary" value="<?= ($edit_data != '') ? 'Update' : 'Save'; ?>">
        </div>
    </div>
</form>

<h4>Catalog File</h4>

<form class="form-inline" id="EARTHQUAKE_upload" action="<?= esc_url( admin_url('admin-post.php') ); ?>" enctype="multipart/form-data" method="post">
    <input type="hidden" name="action" value="my_simple_form_2">
    <div class="row">
        <div class="col-lg-2">
            <input type="file"  class="form-control" name="fileToUpload" id="fileToUpload"  accept=".csv" required>
        </div>
        <div class="col-lg-2">
            <!-- <input type="submit" name="submit" class="btn btn-primary" value="Save"> -->
        </div>
        <div class="col-lg-2">
            <input type="submit" name="submit" class="btn btn-primary" value="Save">
        </div>
    </div>
</form>
<h4>Existing Files</h4>
<table id="customers">
    <tr>
        <th>File Name</th>
        <th>Date Time</th>
        <th>Magnitude</th>
        <th>Latitide</th>
        <th>Longitude</th>
        <th>Depth</th>
        <th>Region</th>
        <th>Network</th>
        <th>Staion</th>
        <th>Station Name</th>
        <th>Channel</th>
        <th>Location</th>
        <th>Location Lat</th>
        <th>Location Lng</th>
        <th>Scale</th>
        <th>Distance Deg</th>
        <th>Distance Km</th>
        <th>Upload Date Time</th>
        <th>Edit</th>
        <th>Delete</th>
    </tr>
<?php
    global $wpdb;
    $table_name_2 = $wpdb->prefix . 'earth_quake_file';
    $result = $wpdb->get_results ( "SELECT * FROM ".$table_name_2. " where publish=1" );
    foreach ( $result as $print )   {
    ?>
    <tr>
        <td><?= substr($print->file_name, 0, -22) ?>.csv</td>

        <td><?= $print->data_datetime ?></td>
        <td><?= $print->magnitude ?></td>
        <td><?= $print->latitide ?></td>
        <td><?= $print->longitude ?></td>
        <td><?= $print->depth ?></td>
        <td><?= $print->region ?></td>
        <td><?= $print->network ?></td>
        <td><?= $print->station ?></td>
        <td><?= $print->station_name ?></td>
        <td><?= $print->channel ?></td>
        <td><?= $print->location ?></td>
        <td><?= $print->loc_latitude ?></td>
        <td><?= $print->loc_longitude ?></td>
        <td><?= $print->scale ?></td>
        <td><?= $print->distance_deg ?></td>
        <td><?= $print->distance_km ?></td>

        <td><?= $print->upload_datetime ?></td>
        <td>
            <a href = "<?= get_admin_url().'admin.php?page=earthquakeupload&edit='.$print->id ?>"><img class="icon-wdt" src="<?= EARTHQUAKE_URL ?>/images/edit.png" /></a>
        </td>
        <td>
            <a href = "<?= get_admin_url().'admin.php?page=earthquakeupload&delete='.$print->id ?>"><img class="icon-wdt" src="<?= EARTHQUAKE_URL ?>/images/delete.png" /></a>
        </td>
    </tr>
        
<?php }
  
  
  ?>

 </table>

   <script src="https://cdn.tiny.cloud/1/oyjobvru7qgskcwialh5k4ww4dsq76pwgrxcscu6b8zcbwwo/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
  <script>tinymce.init({selector:'textarea'});</script>