<?php 

// Výpis uživatelů
	include("classes/User.php");
	echo 
	"<script type='module' src='js/model-viewer.min.js'></script>
	
			<div class='table-responsive'>   
			<table style='margin:0em' class='table table-dark table-condensed'>
			"; 

			
			echo "
				<tr>
					<th>ID</th>
					<th>Už. jméno</th>
					<th>Jméno</th>
					<th>Příjmení</th>
					<th>Pohlaví</th>
					<th>E-mail</th>
					<th>Reset hesla</th>
					<th>Datum narození</th>
					<th>Místo narození</th>
					<th>Role</th>
					<th>Akce</th>
					
				</tr>";

				$users = Db::queryAll("SELECT * FROM astronet_users");

				$i = 0;
				foreach($users as $userdb){
					$user = new User($userdb["username"], $userdb["mail"], $userdb["password"],$userdb["name"],$userdb["surname"],$userdb["sex"], $userdb["city_id"], $userdb["born_date"], $userdb["role"], $userdb["password_reset"]);
					$user->setID($userdb["id"]);
					$i+=1;

						echo "<tr id='row_user_$user->id'>\n";
						echo "<th>".$user->id."</th>\n";
						echo "<td>".$user->username."</td>\n";
						echo "<td>".$user->name."</td>\n";
						echo "<td>".$user->surname."</td>\n";
						echo "<td>";
						if($user->sex){
							echo "Žena";
						}else{
							echo "Muž";
						}

						echo "</td>\n";

						echo "<td>".$user->mail."</td>\n";
						echo "<td>";
						if($user->password_reset){
							echo "Čeká na změnu";
						}else{
							echo "Ne";
						}

						echo "</td>\n";
						$datearr = explode("-",$user->born_date);
						echo "<td>" .$datearr[2]. "." . $datearr[1] . ".".$datearr[0]. "</td>\n";
						echo "<td>".Db::querySingle($user->bornCitySql())."</td>\n";
						echo "<td>";
						if($user->role){
							echo "Admin";
						}else{
							echo "Uživatel";
						}

						echo "</td>\n";

						echo "<td>"."<button  data-toggle='collapse' data-target='#user$i' class='accordion-toggle'>	&#128065;</button>"."</td>\n";

						echo "</tr>";
						echo "<tr>";
						echo "<td class='hiddenRow' colspan='11'>
							<div class='accordian-body collapse' id='user$i'> ";
						
						echo "<table class='table table-dark table-condensed'>";
						echo "<tr>";
						
						/*echo "<th>".""."</th>";
						echo "<th>".""."</th>";
						echo "<th>".""."</th>";*/

						//echo "<td>".$planet["year"]."</td>\n";
						echo "</tr>";

						echo "<tr>";

						echo "<th>" . "Správa uživatele" . "</th>";
						$id = $user->id;
						echo "<td>"."<a href='?page=edit&table=users&id=$id&action=edit' class='btn btn-secondary mr-2' style='margin-left:-5em'>Upravit</a>";
						echo "<a href='?page=edit&table=users&id=$id&action=delete' class='btn btn-secondary mr-2'>Smazat</a>";
						echo "<a href='?page=edit&table=users&id=$id&action=resetpass' class='btn btn-secondary mr-2'>Resetovat heslo</a>";
						echo "</td>\n";

					
						//echo "<td><a>"."api"."</a></td>\n";

						echo "</tr>";
						
						
						
						echo "</div";
						echo "</td>\n";

						echo "</table>";
						
						
						echo "</div>";
						echo "</td>\n";

					echo "</tr>";
				}
				echo "
				</table>
				</div>	
				</div>
				</div>";

?>