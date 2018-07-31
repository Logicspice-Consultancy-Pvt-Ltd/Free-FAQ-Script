<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<!--[if !mso]><!-->
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<!--<![endif]-->
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Untitled Document</title>

<style>
            /* Basics */
body {
	Margin: 0;
	padding: 0;
	min-width: 100%;
	background-color: #f3f3f3;
}
*{ box-sizing:border-box; padding:0; margin:0;}
table {
	border-spacing: 0;
	font-family: sans-serif;
	color: #333333;
}
td {
	padding: 0;
}
img {
	border: 0;
}
.wrapper {
	width: 100%;
	table-layout: fixed;
	-webkit-text-size-adjust: 100%;
	-ms-text-size-adjust: 100%;
}
.webkit {
	max-width: 600px;
}
.outer {
	Margin: 0 auto;
	width: 100%;
	max-width: 600px;
}
.inner {
	padding: 10px;
}
.contents {
	width: 100%;
}
p {
	Margin: 0;
}
a {
	color: #ee6a56;
	text-decoration: underline;
}
.h1 {
	font-size: 21px;
	font-weight: bold;
	Margin-bottom: 18px;
}
.h2 {
	font-size: 18px;
	font-weight: bold;
	Margin-bottom: 12px;
}
.full-width-image img {
	height: auto; display:block; max-width:100%;
}

/* One column layout */
.one-column .contents {
	text-align: left;
}
.one-column p {
	font-size: 14px;
	Margin-bottom: 10px;
}
.one-column p.h1 {
	font-size: 32px;
	font-weight: normal;
	Margin-bottom: 18px; color:#333;
}
.one-column p.anter{ margin-top:40px;}
.one-column p.anter a {
	font-size: 18px; background:#4a0611; border-radius:0px;
	font-weight: normal; padding:13px 20px; text-decoration:none;
	 color:#ffffff;
}
.one-column p.anter a:hover{ color:#fff; background-color:#bf203e;}
/*Two column layout*/
.two-column {
	text-align: center;
	font-size: 0;
}
.two-column .column {
	width: 100%;
	max-width: 300px;
	display: inline-block;
	vertical-align: top;
}
.two-column .contents {
	font-size: 14px;
	text-align: left;
}
.two-column img {
	width: 100%;
	max-width: 280px;
	height: auto;
}
.two-column .text {
	padding-top: 10px;
}

/*Three column layout*/
.three-column {
	text-align: center;
	font-size: 0;
	padding-top: 10px;
	padding-bottom: 10px;
}
.three-column .column {
	width: 100%;
	max-width: 200px;
	display: inline-block;
	vertical-align: top;
}
.three-column img {
	width: 100%;
	max-width: 180px;
	height: auto;
}
.three-column .contents {
	font-size: 14px;
	text-align: center;
}
.three-column .text {
	padding-top: 10px;
}

/* Left sidebar layout */
.left-sidebar {
	text-align: center;
	font-size: 0;
}
.left-sidebar .column {
	width: 100%;
	display: inline-block;
	vertical-align: middle;
}
.left-sidebar .left {
	max-width: 100px;
}
.left-sidebar .right {
	max-width: 500px;
}
.left-sidebar .img {
	width: 100%;
	max-width: 80px;
	height: auto;
}
.left-sidebar .contents {
	font-size: 14px;
	text-align: center;
}
.left-sidebar a {
	color: #85ab70;
}

/* Right sidebar layout */
.right-sidebar {
	text-align: center;
	font-size: 0;
}
.right-sidebar .column {
	width: 100%;
	display: inline-block;
	vertical-align: middle;
}
.right-sidebar .left {
	max-width: 100px;
}
.right-sidebar .right {
	max-width: 500px;
}
.right-sidebar .img {
	width: 100%;
	max-width: 80px;
	height: auto;
}
.right-sidebar .contents {
	font-size: 14px;
	text-align: center;
}
.right-sidebar a {
	color: #70bbd9;
}
.lins a{ text-decoration:none; font-size:14px; padding:4px 7px; color:#fff; background-color:#bf203e;}
.lins a:hover{ color:#fff; text-decoration:none; background-color:#4a0611 }

/*Media Queries*/
@media screen and (max-width: 400px) {
	.two-column .column,
	.three-column .column {
		max-width: 100% !important;
	}
	.two-column img {
		max-width: 100% !important;
	}
	.three-column img {
		max-width: 50% !important;
	}
}

@media screen and (min-width: 401px) and (max-width: 620px) {
	.three-column .column {
		max-width: 33% !important;
	}
	.two-column .column {
		max-width: 50% !important;
	}
}
        </style>
</head>

<body>

	<center class="wrapper">
		<div class="webkit">
			<table class="outer" align="center" cellspacing="0" style="border-collapse:collapse;">
            <tr>
                <td class="full-width-image" style="padding:10px 0;"><?php echo $this->Html->image('logo2.jpg', ['alt' => SITE_TITLE]); ?>
					</td>
                    <td class="full-width-image lins" style="padding:10px 0; text-align:right;">
                    <a href="#">Home</a>
                    <a href="#">About Us</a>
                    <a href="#">Home</a>
                    <a href="#">Contact Us</a>
                    
					</td>
				</tr>
                                
                                <?php echo $content_for_layout; ?>
                
<!--                <tr>
					<td class="one-column" colspan="2">
						<table width="100%" style="background:#FFFFFF; border-top:4px #4a0611 solid;">
							<tr>
								<td class="inner contents" style="text-align:center; padding:50px;">
									<p class="h1" style="text-transform:uppercase; font-weight:bold; color:#4a0611;	">You’re Looking Good!</p>
									<p style="line-height:25px; color:#4a0611;">
                                    We love seeing how you’re using our latest Products.<br>
                                  Here are just a few of our favorite looks from Instagram.</p>
                                    <p class="anter"><a href="#">Verify email address.</a></p>
								</td>
							</tr>
						</table>
					</td>
				</tr>-->
                
                
                <tr>
					<td class="one-column" style="padding-top:5px;" colspan="2">
						<table width="100%" style="background-color:#ffffff;">
							<tr>
								<td class="inner contents" style="text-align:center; padding:30px;">
									<p class="h1" style="font-size:16px; color:#4a0611; text-transform:uppercase; font-weight:bold;">Be Sure To Follow Us And Join The Fun!</p>
                                    
                                    <p class="social_anter">
                                    <a href="#"><?php echo $this->Html->image('t_logo.jpg', ['alt' => SITE_TITLE]); ?></a>
                                    <a href="#"><?php echo $this->Html->image('f_logo.jpg', ['alt' => SITE_TITLE]); ?></a>
                                    <a href="#"><?php echo $this->Html->image('email_logo.jpg', ['alt' => SITE_TITLE]); ?></a>
                                    </p>
									<p style="line-height:25px; color:#666666;">Email sent by Hailo<br>
Copyright&copy; 2017 Heilo Networks LTD,All rights reserved.</p>
                                    
								</td>
							</tr>
						</table>
					</td>
				</tr>
                
                
            </table>
            </div>
            </center>
</body>
</html>
