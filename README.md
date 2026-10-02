# esaa-2
Team VKM (Victor, Khue, and Martin) for the Edmonton Students Advocacy Association

`Please note this README.md file is still a WIP and content published here is subject for changes`

---
This repo is our custom WordPress theme: the PHP templates, CSS, and JavaScript that control how the site looks and works. We currently build the site on our laptops in LocalWP, review it here on GitHub, and have Hostinger pull each approved change onto our work space at our pending developer site automatically.

---
## 1. One-time setup on your laptop (each teammate)
### Install the tools
1. **LocalWP**: download from [localwp.com](https://localwp.com/) and install. (Currently at version 10.1.2 as of writing)
2. **Git**: either [GitHub Desktop](https://desktop.github.com/) (easiest) or [Git](https://git-scm.com/downloads) for the terminal.

### Create your local WordPress site
1. In LocalWP, click **+** then **Create a new site**. Name it `esaa-vkm`.
2. Choose **Custom** and set the PHP version to match Hostinger. In hPanel, open the vkm website and check **Advanced > PHP Configuration**. 
   * Since there's no Hostinger site yet. Pick **PHP 8.5.1** for now and change it later.
3. Additionally, we'll be using **Apache** for our Web Server and MariaDB 10.11.18 for compatibility with Hostinger
4. Pick any admin username and password. This site only exists on your laptop.
   * You can set up One-click admin after

### Put the theme into your local site
Your themes folder is at:

- **Windows:** `C:\Users\<you>\Local Sites\esaa-vkm\app\public\wp-content\themes`
- **Mac:** `~/Local Sites/esaa-vkm/app/public/wp-content/themes`
(In Local, you can also right-click the site and choose **Reveal in Finder / Show in Folder**, then open `app/public/wp-content/themes`.)

**With GitHub Desktop:** **File > Clone repository > URL**, paste `https://github.com/capstone-1261/esaa-2`, set **Local path** to the themes folder above, then click **Clone**.

**With the terminal:**
```bash
cd "<your themes folder directory>"
git clone https://github.com/capstone-1261/esaa-2.git
```

### Turn the theme on locally
In LocalWP, click **WP Admin**, go to **Appearance > Themes**, and activate **ESAAxVKM**. Open the site and you should see the placeholder page.

## 2. One-time setup on Hostinger (once for the whole team)
Documentation coming soon