<?php
/**
 * Template for LSE Cities newsletters (email channel)
 * 
 *
 * @package LSECities2012
 */
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"
      xmlns:og="http://opengraphprotocol.org/schema/"
      xmlns:fb="http://www.facebook.com/2008/fbml">
<!-- lsecities-2012 newsletter template, based on Mailchimp's templates -->
<head>
        <meta content="text/html; charset=UTF-8" http-equiv="Content-Type">
        
        <!-- Facebook sharing information tags -->
        <meta content="*|MC:SUBJECT|*" property="og:title">
        
        <title>LSE Cities Newsletter | <?php the_title(); ?></title>
		<style type="text/css">
			/* Client-specific Styles */
			#outlook a{padding:0;} /* Force Outlook to provide a "view in browser" button. */
			body{width:100% !important;} /* Force Hotmail to display emails at full width */
			body{-webkit-text-size-adjust:none;} /* Prevent Webkit platforms from changing default text sizes. */
			
			/* Reset Styles */
			body{margin:0; padding:0;}
			img{border:none; font-size:12px; font-weight:bold; height:auto; line-height:100%; outline:none; text-decoration:none; text-transform:capitalize;}
			#backgroundTable{height:100% !important; margin:0; padding:0; width:100% !important;}
			
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
			
			/**
			* @tab Page
			* @section heading 1
			* @tip Set the styling for all first-level headings in your emails. These should be the largest of your headings.
			* @style heading 1
			*/
			h1, .h1{
				/*@editable*/ color:#202020;
				display:block;
				/*@editable*/ font-family:Tahoma,Helvetica,sans-serif;
				/*@editable*/ font-size:34px;
				/*@editable*/ font-weight:bold;
				/*@editable*/ line-height:100%;
				margin-top:0;
				margin-right:0;
				margin-bottom:10px;
				margin-left:0;
				/*@editable*/ text-align:left;
				    background-color: transparent;
    color: #DE1F00;
    font-family: Gotham Medium,Tahoma,Verdana,sans-serif;
    font-size: 1.8em;
    padding-left: 0;
    padding-right: 0;
    text-transform: uppercase;
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
				/*@editable*/ font-family:Tahoma,Helvetica,sans-serif;
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
				/*@editable*/ font-family:Tahoma,Helvetica,sans-serif;
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
				/*@editable*/ font-family:Helvetica,sans-serif;
				/*@editable*/ font-size:16px;
				/*@editable*/ font-weight:bold;
				text-transform: uppercase;
				/*@editable*/ line-height:100%;
				margin-top:0;
				margin-right:0;
				margin-bottom:10px;
				margin-left:0;
				/*@editable*/ text-align:left;
			}
			
			.h4 span {
			 background-color: #DE1F00;
			 color: white !important;
			 font-weight: bold !important;
			 padding-left: 2px;
			 padding-right: 2px;
			}
			
			ul{
			 list-style-type: none;
			 -moz-padding-start: 0;
			 margin-left: 0;
			 padding-left: 0;
			}
			
			li{
			 margin-bottom: 0.5em;
			 margin-left: 0;
			}
			
			a{
			 text-decoration: none !important;
			 color: #B4001D !important;
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
				/*@editable*/ font-family:Tahoma,Helvetica,sans-serif;
				/*@editable*/ font-size:10px;
				/*@editable*/ line-height:100%;
				/*@editable*/ text-align:left;
			}
			
			/**
			* @tab Header
			* @section preheader link
			* @tip Set the styling for your email's preheader links. Choose a color that helps them stand out from your text.
			*/
			.preheaderContent div a:link, .preheaderContent div a:visited{
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
				/*@editable*/ /*background-color:#D8E2EA*/;
				/*@editable*/ border-bottom:0;
			}
			
			/**
			* @tab Header
			* @section header text
			* @tip Set the styling for your email's header text. Choose a size and color that is easy to read.
			*/
			.headerContent{
				/*@editable*/ color:#202020;
				/*@editable*/ font-family:Tahoma,Helvetica,sans-serif;
				/*@editable*/ font-size:34px;
				/*@editable*/ font-weight:bold;
				/*@editable*/ line-height:100%;
				/*@editable*/ padding:0;
				/*@editable*/ text-align:center;
				/*@editable*/ vertical-align:middle;
				text-align: left;
    padding-left: 20px;
    padding-right: 20px;
			}
			
			/**
			* @tab Header
			* @section header link
			* @tip Set the styling for your email's header links. Choose a color that helps them stand out from your text.
			*/
			.headerContent a:link, .headerContent a:visited{
				/*@editable*/ color:#336699;
				/*@editable*/ font-weight:normal;
				/*@editable*/ text-decoration:underline;
			}
			
			#headerImage{
				height:auto;
				max-width:600px;
			}
			
			/* /\/\/\/\/\/\/\/\/\/\ STANDARD STYLING: COLUMNS; LEFT, RIGHT /\/\/\/\/\/\/\/\/\/\ */
			
			/**
			* @tab Columns
			* @section left column text
			* @tip Set the styling for your email's left column text. Choose a size and color that is easy to read.
			*/
			.leftColumnContent{
				/*@editable*/ background-color:#FFFFFF;
			}
			
			/**
			* @tab Columns
			* @section left column text
			* @tip Set the styling for your email's left column text. Choose a size and color that is easy to read.
			*/
			.leftColumnContent div{
				/*@editable*/ color:#505050;
				/*@editable*/ font-family:Tahoma,Helvetica,sans-serif;
				/*@editable*/ font-size:12px;
				/*@editable*/ line-height:150%;
				/*@editable*/ text-align:left;
			}
			
			/**
			* @tab Columns
			* @section left column link
			* @tip Set the styling for your email's left column links. Choose a color that helps them stand out from your text.
			*/
			.leftColumnContent div a:link, .leftColumnContent div a:visited{
				/*@editable*/ color:#336699;
				/*@editable*/ font-weight:normal;
				/*@editable*/ text-decoration:underline;
			}
			
			.leftColumnContent img{
				display:inline;
				height:auto;
			}
			
			/**
			* @tab Columns
			* @section right column text
			* @tip Set the styling for your email's right column text. Choose a size and color that is easy to read.
			*/
			.rightColumnContent{
				/*@editable*/ background-color:#FFFFFF;
			}
			
			/**
			* @tab Columns
			* @section right column text
			* @tip Set the styling for your email's right column text. Choose a size and color that is easy to read.
			*/
			.rightColumnContent div{
				/*@editable*/ color:#505050;
				/*@editable*/ font-family:Tahoma,Helvetica,sans-serif;
				/*@editable*/ font-size:12px;
				/*@editable*/ line-height:150%;
				/*@editable*/ text-align:left;
			}
			
			/**
			* @tab Columns
			* @section right column link
			* @tip Set the styling for your email's right column links. Choose a color that helps them stand out from your text.
			*/
			.rightColumnContent div a:link, .rightColumnContent div a:visited{
				/*@editable*/ color:#336699;
				/*@editable*/ font-weight:normal;
				/*@editable*/ text-decoration:underline;
			}
			
			.rightColumnContent img{
				display:inline;
				height:auto;
			}
			
			/* /\/\/\/\/\/\/\/\/\/\ STANDARD STYLING: MAIN BODY /\/\/\/\/\/\/\/\/\/\ */
			
			/**
			* @tab Body
			* @section body style
			* @tip Set the background color for your email's body area.
			*/
			#templateContainer, .bodyContent{
				/*@editable*/ background-color:#FDFDFD;
			}
			
			/**
			* @tab Body
			* @section body text
			* @tip Set the styling for your email's main content text. Choose a size and color that is easy to read.
			* @theme main
			*/
			.bodyContent div{
				/*@editable*/ color:#505050;
				/*@editable*/ font-family:Tahoma,Helvetica,sans-serif;
				/*@editable*/ font-size:12px;
				/*@editable*/ line-height:150%;
				/*@editable*/ text-align:left;
			}
			
			/**
			* @tab Body
			* @section body link
			* @tip Set the styling for your email's main content links. Choose a color that helps them stand out from your text.
			*/
			.bodyContent div a:link, .bodyContent div a:visited{
				/*@editable*/ color:#336699;
				/*@editable*/ font-weight:normal;
				/*@editable*/ text-decoration:underline;
			}
			
			.bodyContent img{
				display:inline;
				height:auto;
			}
			
			/* /\/\/\/\/\/\/\/\/\/\ STANDARD STYLING: FOOTER /\/\/\/\/\/\/\/\/\/\ */
			
			/**
			* @tab Footer
			* @section footer style
			* @tip Set the background color and top border for your email's footer area.
			* @theme footer
			*/
			#templateFooter{
				/*@editable*/ background-color:#FDFDFD;
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
				/*@editable*/ font-family:Tahoma,Helvetica,sans-serif;
				/*@editable*/ font-size:12px;
				/*@editable*/ line-height:125%;
				/*@editable*/ text-align:left;
			}
			
			/**
			* @tab Footer
			* @section footer link
			* @tip Set the styling for your email's footer links. Choose a color that helps them stand out from your text.
			*/
			.footerContent div a:link, .footerContent div a:visited{
				/*@editable*/ color:#336699;
				/*@editable*/ font-weight:normal;
				/*@editable*/ text-decoration:underline;
			}
			
			.footerContent img{
				display:inline;
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
				/*@editable*/ background-color:#FDFDFD;
				/*@editable*/ border:0;
			}

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

<body marginwidth="0" marginheight="0" offset="0" topmargin="0" leftmargin="0">
<!-- pageContent.begin -->
<center>
  <table width="100%" height="100%" cellspacing="0" cellpadding="0" border="0" id="backgroundTable">
    <tbody>
      <tr>
        <td valign="top" align="center">
          <table width="800" cellspacing="0" cellpadding="10" border="0" id="templatePreheader">
            <tbody>
              <tr>
                <td valign="top" class="preheaderContent">
                  <table width="100%" cellspacing="0" cellpadding="10" border="0">
                    <tbody>
                      <tr>
                        <td valign="top">
                          <div mc:edit="std_preheader_content">
<?php // TODO:introtext ?>
   </div>
                        </td>
                        <td width="190" valign="top">
                          <div mc:edit="std_preheader_links">
             Is this email not displaying correctly?<br/><a target="_blank" href="<?php // TODO:link ?>">View it in your browser</a>.
            </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </td>
              </tr>
            </tbody>
          </table>
          <table width="800" cellspacing="0" cellpadding="0" border="0" id="templateContainer">
            <tbody>
              <tr>
                <td valign="top" align="center">
                  <table width="800" cellspacing="0" cellpadding="0" border="0" id="templateHeader">
                    <tbody>
                      <tr>
                        <td class="headerContent">
                          <a target="_blank" href="http://urban-age.net/">
                            <img mc:allowtext="" mc:allowdesigner="" mc:edit="header_image" mc:label="header_image" id="headerImage campaign-icon" style="max-width: 600px;" src="<?php // TODO:link ?>"/>
                          </a>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </td>
              </tr>
              <tr>
                <td valign="top" colspan="3" class="bodyContent">
                  <table width="100%" cellspacing="0" cellpadding="20" border="0">
                    <tbody>
                      <tr>
                        <td valign="top">
                          <div mc:edit="std_content00">
                            <h1 class="h1">LSE Cities Newsletter | <?php the_title(); ?></h1>
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </td>
              </tr>
              <tr>
                <td valign="top" align="center">
                  <table width="800" cellspacing="0" cellpadding="0" border="0" id="templateBody">
                    <tbody>
                      <tr>
                        
                        
                        
                        
                        
                        
                        
                        

<?php
// Set up the objects needed
$sections = get_pages(array(
  'parent' => $post->ID,
  'post_type' => 'page',
  'sort_column'  => 'menu_order',
  'hierarchical' => 0
));

foreach($sections as $section) {
  $featured_items = get_pages(array(
    'parent' => $section->ID,
    'post_type' => 'page',
    'sort_column'  => 'menu_order',
    'meta_key' => 'toc_title',
    'hierarchical' => 0
  ));
  include('header-section-email.php');
}
?>




                      </tr>
                    </tbody>
                  </table>
                </td>
              </tr>
              <tr>
                <td valign="top" colspan="3" class="bodyContent">
                  <table width="100%" cellspacing="0" cellpadding="20" border="0">
                    <tbody>
                      <tr>
                        <td valign="top">
                          <div mc:edit="std_content00" style="border-top: 1px solid rgb(153, 153, 153);">
                            <h4 class="h4">
                              <span>Read more</span>
                            </h4>
                            <p>For the full LSE Cities newsletter, <a target="_blank" href="<?php // TODO:link ?>">click here</a>.</p>
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </td>
              </tr>
              <tr>
                <td valign="top" align="center">
                  <table width="800" cellspacing="0" cellpadding="10" border="0" id="templateFooter">
                    <tbody>
                      <tr>
                        <td valign="top" class="footerContent">
                          <table width="100%" cellspacing="0" cellpadding="10" border="0">
                            <tbody>
                              <tr>
                                <td valign="middle" id="social" colspan="2">
                
              </td>
                              </tr>
                              <tr>
                                <td valign="middle" id="utility" colspan="2">
                                  <div mc:edit="std_utility">
                                    <a href="*|UNSUB|*">unsubscribe from this list</a>
                                  </div>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </td>
              </tr>
            </tbody>
          </table>
          <br/>
        </td>
      </tr>
    </tbody>
  </table>
</center>

<!-- pageContent.end -->
</body>
</html>


