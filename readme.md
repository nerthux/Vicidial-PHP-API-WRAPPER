##Vicidial API PHP WRAPPER

**DISCLAIMER:** *VICIdial is a registered trademark of the Vicidial Group which i am not related in anyway.*

VICIDIAL is a software suite that is designed to interact with the Asterisk Open-Source PBX Phone system to act as a complete inbound/outbound contact center suite with inbound email support as well. 

http://www.vicidial.org/vicidial.php

Vicidial has an AGENT API and NON AGENT API, this classes are intended to make it easier to use in PHP

* http://vicidial.org/docs/NON-AGENT_API.txt
* http://vicidial.org/docs/AGENT_API.txt

### How to use it

#### Example 1: Update fields on agent screen

```
require 'vicidialAgentAPI.php';

$fields['first_name'] = "John";
$fields['last_name'] = "Doe";
$fields['address1'] = "123 Fake St";

try {
        $vicidialAPI = new VicidialAgentAPI("127.0.0.1", "VicidialAPI", "gabriel", "Sup3rP4ss",true);
        $vicidialAPI->update_fields("gabriel", $fields);
} catch (Exception $e) {
            echo 'Exception: ',  $e->getMessage(), "\n";
}
```

#### Example 2: Hangup Call, Dispo it and Pause Agent

```
require 'vicidialAgentAPI.php';

try {
        $vicidialAPI = new VicidialAgentAPI("127.0.0.1", "VicidialAPI", "gabriel", "Sup3rP4ss",true);
        $vicidialAPI->pause("gabriel", "PAUSE");
        $vicidialAPI->hangup("gabriel");
        $vicidialAPI->dispo("gabriel", "SALE");
} catch (Exception $e) {
            echo 'Exception: ',  $e->getMessage(), "\n";
}


###TODO

This is a work in progress, still working on finish the Agent API, after that i will add a NON Agent API Class

