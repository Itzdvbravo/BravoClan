# BravoClan<img src="https://raw.githubusercontent.com/Itzdvbravo/BravoClan/master/new.png" height="64" width="64" align="left"></img>

[![Poggit](https://poggit.pmmp.io/shield.state/BravoClan)](https://poggit.pmmp.io/p/BravoClan)
[![Poggit](https://poggit.pmmp.io/shield.dl.total/BravoClan)](https://poggit.pmmp.io/p/BravoClan)
[![Poggit](https://poggit.pmmp.io/shield.dl/BravoClan)](https://poggit.pmmp.io/p/BravoClan)
[![Poggit](https://poggit.pmmp.io/shield.api/BravoClan)](https://poggit.pmmp.io/p/BravoClan)

This is a simple clan plugin, it was made because there is very few (or no) working clan plugin without claims, just simple grouping system with levels.

### Features
- [x] Pvp-wise the clan plugin will work only in the worlds given in config.yml
- [x] [Scorehud compatible](https://github.com/JackMD/ScoreHud-Addons)
- [x] Clan system, obviously.
- [x] Earn XP on kill, Lose XP on death
- [x] Level up after you reach a certian XP [Click Here for how the system works](https://github.com/Itzdvbravo/BravoClan/blob/master/README.md#clan-system)
- [x] Get more space for clan members as you level up
- [x] Get clan info, clan member info.
- [x] Clan chat

### Latest Version Changes  
- Updated to pmmp 3.14.2

### Clan System

- **Level System**  
The clan level system is quite basic but interestic and kindof different than others _(Currently the amount of xp needed to level up isn't configurable however The amount of xp you lose, you gain can be configured in config.yml)_.  
The first level is 100 xp (Leader can invite 2 members only), after the clan has more than 100 xp, they will level up and reach level 2.
Now, After every 5 levelup it will open X amount of member space. After you level up, the xp needed to levelup + 250 xp will be needed for next level up i.e, to get level 3 you need to get 350xp (100 + 250).  
If you die you lose xp.

- **Rank System**  
There are only two ranks in the clan, leader and members.  

### Commands
| Command | Description | Leader Only |
| --- | --- | --- |
| `/clan create` | Create a clan if you aren't already in a clan | `No` |
| `/clan invite` | Invite members to your clan | `Yes` | 
| `/clan accept` | Accept an invitation from a clan |` No` |
| `/clan chat` | Join your clan chat | `No` |
| `/clan info` | Get your or others clan info | `No` |
| `/clan members` | Get member info of your or others clan. | `No` |
| `/clan kick` | Invite members to your clan | `Yes` |
| `/clan delete` | Delete your clan | `Yes` |
| `/clan leave` | Leave your clan | `Member Only` |
| `/clan top` | Get top 10 clans | `No` |

### Upcoming Projects
- [x] More configurable
- [x] More efficient member limit system 
- [x] Uh idk XD
