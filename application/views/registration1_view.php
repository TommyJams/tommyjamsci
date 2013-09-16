<iframe src="https://www.facebook.com/plugins/registration?
		client_id=<?php echo $appId;?>&
		redirect_uri=base_url().'fbconnect/registerMethod/fbregistered'&
		fb_only=true&fb_register=true&fields=<?php echo $fb_fields;?>"
	scrolling="auto"
	frameborder="no"
	style="border:none"
	allowTransparency="true"
	width="100%"
	height="330">

</iframe>