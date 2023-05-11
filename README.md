# LibraryManagementSystem

```
Unix Friendly

LMS - Library Management System

    .____    ._____.                                
    |    |   |__\_ |______________ _______ ___.__.  
    |    |   |  || __ \_  __ \__  \\_  __ <   |  |  
    |    |___|  || \_\ \  | \// __ \|  | \/\___  |  
    |_______ \__||___  /__|  (____  /__|   / ____|  
            \/       \/           \/       \/       
   _____          __           _____.__.__          
  /     \ _____  |  | __ _____/ ____\__|  |   ____  
 /  \ /  \\__  \ |  |/ // __ \   __\|  |  | _/ __ \ 
/    Y    \/ __ \|    <\  ___/|  |  |  |  |_\  ___/ 
\____|__  (____  /__|_ \\___  >__|  |__|____/\___  >
        \/     \/     \/    \/                   \/ 

Requirements for makefile docker procedure:

- Need make, git, curl, xterm, net-tools (netstat), composer
- php 7.2.x (with php-curl php-cli php-ext php-xml)
- docker ce 18 should be running as service
- docker-compose version >= 1.21 should be installed
- port 3366 should be free on your host
- sysctl -w vm.max_map_count=262144

* env & composer update before first use.
* First launch will take some times for containers to come up, please be patient

Type "make help" for instructions