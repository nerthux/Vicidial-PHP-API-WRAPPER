#Vicidial API PHP WRAPPER

*DISCLAIMER:* **VICIdial is a registered trademark of the Vicidial Group which i am not related in anyway.**

VICIDIAL is a software suite that is designed to interact with the Asterisk Open-Source PBX Phone system to act as a complete inbound/outbound contact center suite with inbound email support as well. 

http://www.vicidial.org/vicidial.php

Vicidial has an AGENT API and NON AGENT API, this classes are intended to make it easier to use in PHP

http://vicidial.org/docs/NON-AGENT_API.txt
http://vicidial.org/docs/AGENT_API.txt

## How to use it

```
require 'vicidialAgentAPI.php';

$fields['first_name'] = "John";
$fields['last_name'] = "Doe";
$fields['address1'] = "123 Fake St";

try {
        $vicidialAPI = new VicidialAgentAPI("192.168.100.100", "VicidialAPI", "c4tech", "V88Tig1",true);
        $vicidialAPI->update_fields("c4tech", $fields);
} catch (Exception $e) {
            echo 'Exception: ',  $e->getMessage(), "\n";
}
```




