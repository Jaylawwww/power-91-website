# Power 91

Dumaguete music variety station site. Clone it, then start it. No extra coding.

## On another PC (manager demo)

1. Install [Git](https://git-scm.com/download/win) if it is missing.
2. Install [Docker Desktop](https://www.docker.com/products/docker-desktop/) and wait until it says it is running.
3. Clone this repository, then double-click **`start.bat`**.
4. Open **http://localhost:8080**

The first launch downloads images and can take several minutes. Leave the window open while you look at the site.

If this PC already has PHP 8.4+ and Composer, `start.bat` uses those instead and the site is **http://127.0.0.1:8000**.

## Station content

Edit `src/Station/StationCatalog.php` for address, hosts, and the program grid. Save and refresh.
