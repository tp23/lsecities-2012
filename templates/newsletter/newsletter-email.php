<?php
/**
 * Template for LSE Cities newsletters (email channel)
 * 
 *
 * @package LSECities2012
 */
?><?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        
        <!-- Facebook sharing information tags -->
        <meta property="og:title" content="<?php the_title(); ?>" />
        
        <title><?php the_title(); ?></title>
		<style type="text/css">
			/* Client-specific Styles */
			#outlook a{padding:0;} /* Force Outlook to provide a "view in browser" button. */
			body{width:100% !important;} .ReadMsgBody{width:100%;} .ExternalClass{width:100%;} /* Force Hotmail to display emails at full width */
			body{-webkit-text-size-adjust:none;} /* Prevent Webkit platforms from changing default text sizes. */

			/* Reset Styles */
			body{margin:0; padding:0;}
			img{border:0; height:auto; line-height:100%; outline:none; text-decoration:none;}
			table td{border-collapse:collapse;}
			#backgroundTable{height:100% !important; margin:0; padding:0; width:100% !important;}
   p, body, a {
     font-family: Arial, sans-serif;
   }
   a, a:active, a:visited, a:hover {
    text-decoration: none;
	<?php if($theme_skin == 'ec2012'): ?>
	color: #eee111;
	<?php else: ?>
    	color: #de1f00;
	<?php endif; ?>
   }
   a:hover {
    color: #777;
   }
   div p:last-child {
    margin-bottom: 0;
   }

			/* Template Styles */

			/* /\/\/\/\/\/\/\/\/\/\ STANDARD STYLING: COMMON PAGE ELEMENTS /\/\/\/\/\/\/\/\/\/\ */

			/**
			* @tab Page
			* @section background color
			* @tip Set the background color for your email. You may want to choose one that matches your company's branding.
			* @theme page
			*/
			body, #backgroundTable{
				/*@editable*/ background-color:#FAFAFA;
			}

			/**
			* @tab Page
			* @section email border
			* @tip Set the border for your email.
			*/
			#templateContainer{
				/*@editable*/ border: 1px solid #DDDDDD;
			}

			<?php if($theme_skin == 'ec2012'): ?>
			#templateContainer tr {
				background-color: #000000;
			}
			<?php endif; ?>

			/**
			* @tab Page
			* @section heading 1
			* @tip Set the styling for all first-level headings in your emails. These should be the largest of your headings.
			* @style heading 1
			*/
			h1, .h1{
				/*@editable*/ color:#202020;
				display:block;
				/*@editable*/ font-family:Arial;
				/*@editable*/ font-size:34px;
				/*@editable*/ font-weight:bold;
				/*@editable*/ line-height:100%;
				margin-top:0;
				margin-right:0;
				margin-bottom:10px;
				margin-left:0;
				/*@editable*/ text-align:left;
			}

			/**
			* @tab Page
			* @section heading 2
			* @tip Set the styling for all second-level headings in your emails.
			* @style heading 2
			*/
			h2, .h2{
				/*@editable*/ color:#202020;
				display:block;
				/*@editable*/ font-family:Arial;
				/*@editable*/ font-size:30px;
				/*@editable*/ font-weight:bold;
				/*@editable*/ line-height:100%;
				margin-top:0;
				margin-right:0;
				margin-bottom:10px;
				margin-left:0;
				/*@editable*/ text-align:left;
			}

			/**
			* @tab Page
			* @section heading 3
			* @tip Set the styling for all third-level headings in your emails.
			* @style heading 3
			*/
			h3, .h3{
				/*@editable*/ color:#202020;
				display:block;
				/*@editable*/ font-family:Arial;
				/*@editable*/ font-size:26px;
				/*@editable*/ font-weight:bold;
				/*@editable*/ line-height:100%;
				margin-top:0;
				margin-right:0;
				margin-bottom:10px;
				margin-left:0;
				/*@editable*/ text-align:left;
			}

			/**
			* @tab Page
			* @section heading 4
			* @tip Set the styling for all fourth-level headings in your emails. These should be the smallest of your headings.
			* @style heading 4
			*/
			h4, .h4{
				/*@editable*/ color:#202020;
				display:block;
				/*@editable*/ font-family:Arial;
				/*@editable*/ font-size:22px;
				/*@editable*/ font-weight:bold;
				/*@editable*/ line-height:100%;
				margin-top:0;
				margin-right:0;
				margin-bottom:10px;
				margin-left:0;
				/*@editable*/ text-align:left;
			}

			/* /\/\/\/\/\/\/\/\/\/\ STANDARD STYLING: PREHEADER /\/\/\/\/\/\/\/\/\/\ */

			/**
			* @tab Header
			* @section preheader style
			* @tip Set the background color for your email's preheader area.
			* @theme page
			*/
			#templatePreheader{
				/*@editable*/ background-color:#FAFAFA;
			}

			/**
			* @tab Header
			* @section preheader text
			* @tip Set the styling for your email's preheader text. Choose a size and color that is easy to read.
			*/
			.preheaderContent div{
				/*@editable*/ color:#505050;
				/*@editable*/ font-family:Arial;
				/*@editable*/ font-size:10px;
				/*@editable*/ line-height:100%;
				/*@editable*/ text-align:left;
			}

			/**
			* @tab Header
			* @section preheader link
			* @tip Set the styling for your email's preheader links. Choose a color that helps them stand out from your text.
			*/
			.preheaderContent div a:link, .preheaderContent div a:visited, /* Yahoo! Mail Override */ .preheaderContent div a .yshortcuts /* Yahoo! Mail Override */{
				/*@editable*/ color:#336699;
				/*@editable*/ font-weight:normal;
				/*@editable*/ text-decoration:underline;
			}

			/* /\/\/\/\/\/\/\/\/\/\ STANDARD STYLING: HEADER /\/\/\/\/\/\/\/\/\/\ */

			/**
			* @tab Header
			* @section header style
			* @tip Set the background color and border for your email's header area.
			* @theme header
			*/
			#templateHeader{
				/*@editable*/ background-color:#FFFFFF;
				/*@editable*/ border-bottom:0;
			}

			/**
			* @tab Header
			* @section header text
			* @tip Set the styling for your email's header text. Choose a size and color that is easy to read.
			*/
			.headerContent{
				/*@editable*/ color:#202020;
				/*@editable*/ font-family:Arial;
				/*@editable*/ font-size:34px;
				/*@editable*/ font-weight:bold;
				/*@editable*/ line-height:100%;
				/*@editable*/ padding:0;
				/*@editable*/ text-align:left;
				/*@editable*/ vertical-align:middle;
			}

			/**
			* @tab Header
			* @section header link
			* @tip Set the styling for your email's header links. Choose a color that helps them stand out from your text.
			*/
			.headerContent a:link, .headerContent a:visited, /* Yahoo! Mail Override */ .headerContent a .yshortcuts /* Yahoo! Mail Override */{
				/*@editable*/ color:#336699;
				/*@editable*/ font-weight:normal;
				/*@editable*/ text-decoration:underline;
			}

			#headerImage{
				height:auto;
				max-width:600px !important;
			}

   h1#headerTitle, h1.headerTitle {
   <?php if($theme_skin == 'ec2012'): ?>
    background-color: #eee111;
    color: #000000;
   <?php else: ?>
    background-color: #de1f00;
    color: #ffffff;
	<?php endif; ?>
    font-size: 1.5em;
    display: inline-block;
    text-transform: uppercase;
    padding: 0 20px;
   }

   .extended-table-of-contents h1.headerTitle a {
     color: #fff;
     text-decoration: none;
     font-weight: normal;
     font-size: 0.85em;
   }
  
   h1#headerTitle.detached, h1.headerTitle.detached {
     background-color: transparent;
     color: #000;
     font-size: 1.5em;
     display: block;
     text-transform: uppercase;
     padding: 20px;
     padding-bottom: 0;
   }
			/* /\/\/\/\/\/\/\/\/\/\ STANDARD STYLING: MAIN BODY /\/\/\/\/\/\/\/\/\/\ */

			/**
			* @tab Body
			* @section body style
			* @tip Set the background color for your email's body area.
			*/
			#templateContainer, .bodyContent{
				/*@editable*/ background-color:#FFFFFF;
			}

			/**
			* @tab Body
			* @section body text
			* @tip Set the styling for your email's main content text. Choose a size and color that is easy to read.
			* @theme main
			*/
			.bodyContent div{
			<?php if($theme_skin == 'ec2012'): ?>
				color: #ffffff;
			<?php else: ?>
				/*@editable*/ color:#505050;
			<?php endif; ?>
				/*@editable*/ font-family:Arial;
				/*@editable*/ font-size:14px;
				/*@editable*/ line-height:150%;
				/*@editable*/ text-align:left;
			}

			/**
			* @tab Body
			* @section body link
			* @tip Set the styling for your email's main content links. Choose a color that helps them stand out from your text.
			*/
			.bodyContent div a:link, .bodyContent div a:visited, /* Yahoo! Mail Override */ .bodyContent div a .yshortcuts /* Yahoo! Mail Override */{
			<?php if($theme_skin == 'ec2012'): ?>
				color: #eee111;
			<?php else: ?>
				/*@editable*/ color:#336699;
			<?php endif; ?>
				/*@editable*/ font-weight:normal;
				/*@editable*/ text-decoration:underline;
			}

			.bodyContent img{
				display:inline;
				height:auto;
			}
   
   div.section h2 {
    background-color: #de1f00;
    color: #fff;
    font-size: 1.2em;
    display: inline-block;
    text-transform: uppercase;
    padding: 0 20px;
    margin-left: -20px;
   }

   dl dt{
    font-weight: bold;
   }
   
   .bodyContent div dl dt a, .bodyContent div dl dt a:active, .bodyContent div dl dt a:visited, .bodyContent div dl dt a:link{
    font-weight: bold;
    text-decoration: none; 
   }
   
   dl dd{
    margin-left: 0;
   }
   
   div.section {
     border-top: 1px solid #E1E2E3;
   }

			/* /\/\/\/\/\/\/\/\/\/\ STANDARD STYLING: FOOTER /\/\/\/\/\/\/\/\/\/\ */

			/**
			* @tab Footer
			* @section footer style
			* @tip Set the background color and top border for your email's footer area.
			* @theme footer
			*/
			#templateFooter{
				/*@editable*/ background-color:#FFFFFF;
				/*@editable*/ border-top:0;
			}

			/**
			* @tab Footer
			* @section footer text
			* @tip Set the styling for your email's footer text. Choose a size and color that is easy to read.
			* @theme footer
			*/
			.footerContent div{
				/*@editable*/ color:#707070;
				/*@editable*/ font-family:Arial;
				/*@editable*/ font-size:12px;
				/*@editable*/ line-height:125%;
				/*@editable*/ text-align:left;
			}

			/**
			* @tab Footer
			* @section footer link
			* @tip Set the styling for your email's footer links. Choose a color that helps them stand out from your text.
			*/
			.footerContent div a:link, .footerContent div a:visited, /* Yahoo! Mail Override */ .footerContent div a .yshortcuts /* Yahoo! Mail Override */{
			<?php if($theme_skin == 'ec2012'): ?>
				color: #eee111;
			<?php else: ?>
				/*@editable*/ color:#336699;
			<?php endif; ?>
				/*@editable*/ font-weight:normal;
				/*@editable*/ text-decoration:underline;
			}

			.footerContent img{
				display:inline;
			}
   
   .footerContent, .footerContent a {
    font-size: 12px;
    font-family: Arial, sans-serif;
   }
   
   .footerContent h1{
    font-size: 20px;
   }
   
			/**
			* @tab Footer
			* @section social bar style
			* @tip Set the background color and border for your email's footer social bar.
			* @theme footer
			*/
			#social{
				/*@editable*/ background-color:#FAFAFA;
				/*@editable*/ border:0;
			}

			/**
			* @tab Footer
			* @section social bar style
			* @tip Set the background color and border for your email's footer social bar.
			*/
			#social div{
				/*@editable*/ text-align:center;
			}

			/**
			* @tab Footer
			* @section utility bar style
			* @tip Set the background color and border for your email's footer utility bar.
			* @theme footer
			*/
			#utility{
			<?php if($theme_skin == 'ec2012'): ?>
				background-color: #000000;
			<?php else: ?>
				/*@editable*/ background-color:#FFFFFF;
				/*@editable*/ border:0;
			}
			<?php endif; ?>

			/**
			* @tab Footer
			* @section utility bar style
			* @tip Set the background color and border for your email's footer utility bar.
			*/
			#utility div{
				/*@editable*/ text-align:center;
			}

			#monkeyRewards img{
				max-width:190px;
			}
		</style>
	</head>
    <body leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0">
    	<center>
        	<table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="backgroundTable">
            	<tr>
                	<td align="center" valign="top">
                        <!-- // Begin Template Preheader \\ -->
                        <table border="0" cellpadding="10" cellspacing="0" width="600" id="templatePreheader">
                            <tr>
                                <td valign="top" class="preheaderContent">
                                
                                	<!-- // Begin Module: Standard Preheader \ -->
                                    <table border="0" cellpadding="10" cellspacing="0" width="100%">
                                    	<tr>
                                        	<td valign="top">
                                            	<div mc:edit="std_preheader_content">
                                               <?php $teaser = get_post_meta(get_the_ID(), "campaign_teaser_text", true);
                                                 echo $teaser;
                                               ?>
                                              </div>
                                            </td>
                                            <!-- *|IFNOT:ARCHIVE_PAGE|* -->
											<td valign="top" width="190">
                                            	<div mc:edit="std_preheader_links">
													<p>
                                                	Is this email not displaying correctly?<br /><a href="<?php echo $newsletter['our_permalink']; ?>" target="_blank">View it in your browser</a>.
                                                	</p>
                                                </div>
                                            </td>
											<!-- *|END:IF|* -->
                                        </tr>
                                    </table>
                                	<!-- // End Module: Standard Preheader \ -->
                                
                                </td>
                            </tr>
                        </table>
                        <!-- // End Template Preheader \\ -->
                    	<table border="0" cellpadding="0" cellspacing="0" width="600" id="templateContainer">
                        	<tr>
                            	<td align="center" valign="top">
                                    <!-- // Begin Template Header \\ -->
                                	<table border="0" cellpadding="0" cellspacing="0" width="600" id="templateHeader">
                                        <tr>
                                            <td class="headerContent">
                                            
                                            	<!-- // Begin Module: Standard Header Image \\ -->
                                             <?php
                                             $heading_link = get_post_meta(get_the_ID(), "campaign_heading_link", true);
                                             if($TRACE_ENABLED) {
                                               error_log('post ID: ' . get_the_ID());
                                               error_log('campaign_heading_link: ' . $heading_link);
                                             }
                                             if($heading_link) {
                                               echo "<a target='_blank' href='$heading_link'>";
                                             }
                                            	echo get_the_post_thumbnail();
                                             if($heading_link) {
                                               echo "</a>";
                                             }
                                             ?>
                                            	<!-- // End Module: Standard Header Image \\ -->
                                            
                                            </td>
                                        </tr>
                                        <?php if(!$hide_newsletter_title): ?>
                                        <tr>
                                            <td>
                                              <h1 id="headerTitle"<?php if($newsletter_title_extra_classes): ?> class="<?php echo $newsletter_title_extra_classes; ?>"<?php endif; ?>><?php the_title(); ?></h1>
                                            </td>
                                        </tr>
                                        <?php endif; ?>
                                    </table>
                                    <!-- // End Template Header \\ -->
                                </td>
                            </tr>
                        	<tr>
                            	<td align="center" valign="top">
                                    <!-- // Begin Template Body \\ -->
                                	<table border="0" cellpadding="0" cellspacing="0" width="600" id="templateBody">
                                    	<tr>
                                            <td valign="top" class="bodyContent">
                                
                                                <!-- // Begin Module: Standard Content \\ -->
                                                <table border="0" cellpadding="20" cellspacing="0" width="100%">
                                                    <tr>
                                                        <td valign="top">
                                                            <div mc:edit="std_content00">





<?php the_content(); ?>


</div>
														</td>
                                                    </tr>
                                                </table>
                                                <!-- // End Module: Standard Content \\ -->
                                                
                                            </td>
                                        </tr>
                                        <tr>
                                          <td>
                                            <div class="extended-table-of-contents">
<?php
foreach($newsletter['sections'] as $key => $section) {
  /**
   * only output the first five sections
   * we typically use the first four sections for content, a fifth
   * section for image credits if needed) and further sections would
   * be for metadata only, so these should not appear in the table of
   * contents in the email channel
   */
  if($key > 4) { break; }
  include('header-section-email.php');
}
?>
                                            </div>
                                          </td>
                                        </tr>
                                    </table>
                                    <!-- // End Template Body \\ -->
                                </td>
                            </tr>
                        	<tr>
                            	<td align="center" valign="top">
                                    <!-- // Begin Template Footer \\ -->
                                	<table border="0" cellpadding="10" cellspacing="0" id="templateFooter">
                                    	<tr>
                                        	<td valign="top" class="footerContent">
                                            
                                            
                                           <table cellpadding="0" cellspacing="0" border="0">
                                             <tbody>
                                               <tr>
                                                 <td valign="top" width="20">&nbsp;</td>
                                                 <td>
                                                   <table cellpadding="0" cellspacing="0" border="0" width="558">
                                                     <tbody>
                                                       <tr>
                                                         <td valign="top" width="134">&nbsp;</td>
							 <td valign="top" width="289">
                                                           <table cellpadding="0" cellspacing="0" border="0" width="289">
                                                             <tbody>
                                                               <tr>
                                                                 <td>
                                                                   <a href="https://facebook.com/lsecities"><img border="0" src="http://lsecities.net/wp-content/themes/lsecities-2012/images/icons/mal/icon_facebook-v2lightblue_27x27.png" alt="Facebook" height="27" width="27" style="display: block;"></a>
                                                                 </td>
                                                                 <td width="5">&nbsp;</td>
                                                                 <td>
                                                                   <a target="_blank" href="https://facebook.com/lsecities">Join us on Facebook</a>
                                                                 </td>
                                                                 <td valign="top" width="20">&nbsp;</td>
                                                                 <td>
                                                                   <a target="_blank" href="https://twitter.com/#!/LSECities"><img border="0" src="http://lsecities.net/wp-content/themes/lsecities-2012/images/icons/mal/icon_twitter-v1lightblue_27x27.png" alt="Twitter" height="27" width="27" style="display: block;"></a>
                                                                 </td>
                                                                 <td width="5">&nbsp;</td>
                                                                 <td>
                                                                   <a href="http://twitter.com/#!/LSECities">Follow us on Twitter</a>
                                                                 </td>
                                                               </tr>
                                                             </tbody>
                                                           </table>
                                                         </td>
                                                         <td valign="top" width="133">&nbsp;</td>
                                                       </tr>
                                                     </tbody>
                                                   </table>
                                                 </td>
                                                 <td valign="top" width="10">&nbsp;</td>
                                               </tr>
                                             </tbody>
                                           </table>


                                                <!-- // Begin Module: Standard Footer \\ -->
                                                
                                                <table border="0" cellpadding="10" cellspacing="0" width="100%">
<!--
                                                    <tr>
                                                        <td valign="top" width="350">
                                                            <div mc:edit="std_footer">
																<em>Copyright &copy; *|CURRENT_YEAR|* *|LIST:COMPANY|*, All rights reserved.</em>
																<br />
																*|IFNOT:ARCHIVE_PAGE|* *|LIST:DESCRIPTION|*
																<br />
																<strong>Our mailing address is:</strong>
																<br />
																*|HTML:LIST_ADDRESS_HTML|**|END:IF|* 
                                                            </div>
                                                        </td>
                                                        <td valign="top" width="190" id="monkeyRewards">
                                                            <div mc:edit="monkeyrewards">
                                                                *|IF:REWARDS|* *|HTML:REWARDS|* *|END:IF|*
                                                            </div>
                                                        </td>
                                                    </tr>
 -->
                                                    <tr>
                                                        <td colspan="2" valign="middle" id="utility">
                                                            <div mc:edit="std_utility">
                                                                &nbsp;<a href="*|UNSUB|*">unsubscribe from this list</a> | <a href="*|UPDATE_PROFILE|*">update subscription preferences</a>&nbsp;
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </table>
                                                <!-- // End Module: Standard Footer \\ -->
                                            
                                            </td>
                                        </tr>
                                    </table>
                                    <!-- // End Template Footer \\ -->
                                </td>
                            </tr>
                        </table>
                        <br />
                    </td>
                </tr>
            </table>
        </center>
    </body>
</html>
<?php endwhile; else: ?>
<p><?php // _e('Sorry, no posts matched your criteria.'); ?></p>
<?php endif; ?>
