<h2>Results</h2>
<?php 

    if (count($results) > 0) {
        // echo $links;
        echo "<h5 style='width: 550px;'>";
        echo (count($results));
        echo "&nbsp;results found</h5>";
        echo '<br />';
        
        foreach ($results as $item) : 
?>
          
        <table class="table table-striped" cellspacing="0" cellpadding="0" style="table-layout: fixed; width: 100%;">
  
                <tr>
                    <th>Name</th>
                    <th>Location</th>
                    <th></th>
                </tr>
          
                <tr>
                    <td><?php echo $item->name; ?></td>
                    <td><?php echo ucwords(strtolower($item->location)); ?></td>
                    <td><a href="<?php echo base_url(); ?>devices/edit/<?php echo $item->id; ?>">More Details</a></td>
                </tr>

        </table>
  <?php endforeach; }?>