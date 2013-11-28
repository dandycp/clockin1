<!--
<script type="text/javascript">
// Shows messages then removes after 3 seconds
window.setTimeout(function() {
    $(".alert alert-success").fadeTo(300, 0).slideUp(100, function(){
        $(this).remove(); 
    });
}, 3000);
</script>
-->
<h2>Notifications</h2>

<table class="table table-striped">
    <thead>
    <tr>
        <th>Message</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>

    <?php
    date_default_timezone_set('Europe/London');
    if ($invoice) {
        $datetime1 = new DateTime($invoice['invoice_due_date']);
        $datetime2 = new DateTime();
        $interval = $datetime1->diff($datetime2);
    ?>

    <tr>
        <td>
            <?php //if ($client->hour_rate == 0 || $client->hour_rate != $client_rate) { echo 'The set hourly rate is now at <span class="badge">'.$client->hour_rate.'</span>'; } ?>
            <?php if ($client->actual_hours > $client->hour_rate) { echo 'The set hourly rate is more than the set rate of <span class="badge">'.$client->hour_rate.'</span>'; } ?>
            <?php if ($client->actual_hours < $client->hour_rate) { echo 'The set hourly rate is less than the set rate of <span class="badge">'.$client->hour_rate.'</span>'; } ?>

            <?php if ($invoice['invoice_status'] != 'paid') { echo 'A invoice is oustanding by <strong style="color:#C5253B; font-weight: bold;">'.$interval->format('%d days').'</strong> action is required.'; } else { echo 'Nothing to report'; }?>
        </td>
        <td><?php if ($invoice['invoice_status'] != 'paid') { echo '<a href="'.site_url().'clients/view_invoice/'.$invoice['invoice_id'].'" class="btn btn-danger">View invoice</a>'; } else { echo 'Nothing to report'; } ?></td>

    </tr>

    <?php } ?>

    <?php if ($notifications) foreach ($notifications as $notification) : ?>
    <tr>
        <td>
            <?=$notification->content?>
        </td>
        <td>
            &nbsp;
        </td>
    </tr>
    <?php endforeach ?>

    </tbody>

</table>
