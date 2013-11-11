<h1>Work Description</h1>
<? if ($message = $this->session->flashdata('message')) : ?>
<div class="alert alert-success"><button type="button" class="close" aria-hidden="true">&times;</button>
<strong>Info: </strong> <?=$message?></div>
<? endif ?>
<h4>Enter description of works that may be carried out across all sites</h4>
<a class="btn btn-success" href="<?php echo site_url(); ?>clients/categories/add">Add New</a><br /><br />
<? if ($categories) : ?>
<table class="table table-striped">
<thead>
<tr><th>Name</th><th>Comments</th><th>Actions</th></tr>
<tbody>
<? foreach ($categories as $category) : ?>
<tr>
<td><?=$category->name?></td>
<td><?=$category->notes?></td>
<td>
<a class="btn btn-warning" href="<?php echo site_url(); ?>clients/categories/edit/<?=$category->id?>">Edit</a> 
<a class="btn btn-danger" href="<?php echo site_url(); ?>clients/categories/delete/<?=$category->id?>">Delete</a>
</td>
</tr>
<? endforeach ?>
</tbody>
</table>

<? else : ?>
<p class="alert alert-info"><strong>You do not currently have any work descriptions set up.</strong><br />
You can set up a list of work descriptions on your account. This allows you to optionally select which category/work description a particular log entry applies to for reporting purposes.</p>
<? endif ?>

