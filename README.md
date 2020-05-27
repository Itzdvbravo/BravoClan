# BravoClan

[![Poggit](https://poggit.pmmp.io/shield.state/BravoClan)](https://poggit.pmmp.io/p/BravoClan)

This is a simple clan plugin, it was made because there is very few (or no) working clan plugin without claims, just simple grouping system with levels.

### Features

- [x] Clan system, obviously.
- [x] Earn XP on kill, Lose XP on death
- [x] Level up after you reach a certian XP [Click Here for how the system works](https://github.com/Itzdvbravo/BravoClan/blob/master/README.md#clan-system)
- [x] Get more space for clan members as you level up
- [x] Get clan info, clan member info.
- [x] Clan chat

### Clan System

- Level System
The clan level system is quite basic but interestic and kindof different than others _(Currently the amount of xp needed to level up isn't set however The amount of xp you lose, you gain can be configured in config.yml)_.
The first level is 100 xp (Leader can invite 2 members only), after the clan has more than 100 xp, they will level up and reach level 2.
Now, every levelup will open one more space for members for the clan. After you level up, the xp needed to levelup + 250 xp will be needed for next level up i.e, to get level 3 you need to get 350xp (100 + 250).

If you die you lose xp.

- Rank System
There are only two ranks in the clan, leader and members.

### Commands
- [x] /clan info
- [x] /clan create
- [x] /clan invite
- [x] /clan chat
- [x] /clan members
- [x] /clan kick
- [x] /clan delete
- [x] /clan leave
- [x] /clan accept
- [x] /clan top

- Info:<br>  
Get your or others clan info, don't provide a clan name if you want to get info about your clan.  
**Usuage** - /clan info <clan>.  
***NOTE:** Will send an error message to the player using if he ain't in a clan and doesn't provide any clan name.  

- Create<br>  
Create a clan if you aren't already in a clan.  
**Usage** - /clan create <clan name>.  
***NOTE:*** Clan name can only contain letters  

- Invite<br>  
Invite members to your clan  
**Usage** - /clan invite <member>.  
***NOTE:*** Only for clan leaders, won't be able to invite if the clan member limit has reached, will send a message to the player you're inviting, lasts for 30 second  

- Chat<br>  
Join your clan chat.  
**Usage** - /clan chat  
***NOTE:*** Works only if you're in a clan, every online member of your clan can see it even if they ain't in a clan  

- **Members**<br>  
Get member info of your or others clan.  
**Usage** - /clan members <clan>  
***NOTE:*** Won't work if player doesn't provide a clan and isn't in a clan, will show if they're online/offline thier kill/deaths in the clan.  

- **Kick<br>  
Kick a member from a clan.  
**Usage** - /clan kick  
***NOTE:*** Only for clan leaders  

- **Delete<br>  
Delete your clan.  
**Usage** - /clan delete  
***NOTE:*** Only for clan leaders  

- **Leave<br>  
Leave your clan.  
**Usage** - /clan leave  
***NOTE:*** Only works for members, works if you're in a clan.  

- **Accept<br>  
Accept an invitation from a clan.  
**Usage** - /clan accept  
***NOTE:*** Only works if you're not in a clan, if you don't do it in under the 30 second if invitation time it will give expire error.  

- **Top<br>   
Get top 10 clans
**Usage** - /clan top

### Upcoming Projects
- [ ] more configurable
- [ ] Scorehud compatible
- [ ] Purechat compatible
- [ ] More efficient member limit 
