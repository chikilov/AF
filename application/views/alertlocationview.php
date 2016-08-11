<?php require 'inc/config.php'; ?>
<?php require 'inc/views/template_head_start.php'; ?>
<?php require 'inc/views/template_head_end.php'; ?>
<?php require 'inc/views/template_footer_start.php'; ?>
<?php require 'inc/views/template_footer_end.php'; ?>
<script type="text/javascript">
<?php
	if( isset($alertstring) && isset($alerttype) && isset($alertprefix) )
	{
		if ( $alertstring != '' && $alerttype != '' && $alertprefix != '' )
		{
?>
	swal({
        title: "<?php echo $alertprefix; ?>",
        text: "<?php echo $alertstring; ?>",
        type: "<?php echo $alerttype; ?>"
    }
<?php
		}
		if( isset($afterlocation) )
		{
			if ( $afterlocation != '' )
			{
?>
    , function() {
      // Redirect the user
      window.location.href = '<?php echo $afterlocation; ?>';
    }
<?php
			}
?>
	);
<?php
		}
	}
	else
	{
		if( isset($afterlocation) )
		{
			if ( $afterlocation != '' )
			{
?>
	window.location.href = '<?php echo $afterlocation; ?>';
<?php
			}
		}
	}
?>
</script>
