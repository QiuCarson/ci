<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <meta http-equiv=content-type content="text/html; charset=utf-8" />
        <link href="<?php echo config_item('css_url'); ?>/css/admin.css" type="text/css" rel="stylesheet" />
    
         <script language=javascript>
            function expand(el)
            {
                childobj = document.getElementById("child" + el);

                if (childobj.style.display == 'none')
                {
                    childobj.style.display = '';
                }
                else
                {
                    childobj.style.display = 'none';
                }
                return;
            }
        </script>
   
    </head>
    <body>
    	<?php 
    	
    	?>
        <table height="100%" cellspacing=0 cellpadding=0 width=170 background=<?php echo config_item('img_url'); ?>/img/menu_bg.jpg border=0>
             <tr>
                <td valign=top align=middle>
                <?php if($result){?>
                    <?php foreach ($result as $val){?>
                    <table cellspacing=0 cellpadding=0 width=150 border=0>
						<tr height=22>
                            <td style="padding-left: 30px;" background=<?php echo config_item('img_url'); ?>/img/menu_bt.jpg><a class=menuparent onclick=expand(<?php echo $val['id']?>) href="javascript:void(0);"><?php echo $val['menu_name'];?></a></td>
                        </tr>
                        <tr height=4><td></td></tr>
                    </table>
                    <?php if($val['childs']){?>
                    <table id=child<?php echo $val['id'];?> style="display: none" cellspacing=0 cellpadding=0 width=150 border=0>
                    		<?php foreach ($val['childs'] as $val1){?>
							<tr height=20>
                            	<td align=middle width=30><img height=9	src="<?php echo config_item('img_url'); ?>/img/menu_icon.gif" width=9></td>
                            	<td><a class=menuchild	href="<?php echo site_url($val1['menu_url']);?>"	target=main><?php echo $val1['menu_name'];?></a></td>
                            </tr>
                           <?php }?>
                     </table>
                     <?php }?>
                    <?php }
                    
    				}	
    		?>
                </td>
                <td width=1 bgcolor=#d1e6f7></td>
            </tr>
        </table>
    </body>
</html>