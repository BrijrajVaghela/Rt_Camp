<?php

			
			
			//------Sample Json Data Using ufdRecursive function.------";		
			
			//echo "Sample Json Data Using <b>udfRecursive</b> function.<br/><br/>";
			function udfRecursiveTraverse($arr)
			{	
				if(is_array($arr))
				{
					echo "<ul>";
					foreach($arr as $key=>$val)
					{
						if(is_array($val))
						{
							echo "<b><li style='color:red'>$key</li><br/></b>";
							if($key == "albums")
							{
								
							}
							udfRecursiveTraverse($val);
						}
						else
						{
							
							if(is_a($val, 'DateTime'))
							{
								$val = $GLOBALS['profile']['birthday']->format('j-F-Y');
							}
							echo "<li style='color:green'>$key : $val </li><br/>";
						}
					}
					echo "</ul>";
				}
				else
				{
					echo "$key : $val <br/>";
				}
			}
			//------End Of Sample Json Data Using ufdRecursive function.------";		

			
			//------Sample Json Data Using ufdRecursive function.------";		
			
			
			/*<div id="main" class="container">
				 <div id="gallery" class="row">
					<div class="col-xs-4 gallery-item">
					  <div class="album">
						<img src="1.jpg" style=" height:  200px; width: 200px;" alt="" />
						<img src="1.jpg" style=" height:  200px; width: 200px;" alt="" />
						<img src="1.jpg" style=" height:  200px; width: 200px;" alt="" />
						<img src="1.jpg" style=" height:  200px; width: 200px;" alt="" />
						<img src="1.jpg" style=" height:  200px; width: 200px;" alt="" />
						<img src="1.jpg" style=" height:  200px; width: 200px;" alt="" />
						<img src="1.jpg" style=" height:  200px; width: 200px;" alt="" />
						<img src="1.jpg" style=" height:  200px; width: 200px;" alt="" />
						<img src="1.jpg" style=" height:  200px; width: 200px;" alt="" />
					  </div>
					  <p>Holidays</p>
					</div>
				</div>
			</div>*/
		
			
?>