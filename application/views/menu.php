<header>
	<ul id="tabs"></ul>
	<img class="throbber hidden" src="images/spinner.png" />
	<div id="topMenu">
<?php if($this->user->isLogged()){ ?>
		<a href="#profile"><?=$this->user->name?></a>
		<a id="message" href="#message">
			<img src="/images/message.png" alt="消息" />
			<span class="new-messages"><?=$this->message->getNewMessages()?></span>
		</a>
		<a href="/logout" target="_top">退出</a>
		<a href="mailto:uicestone@gmail.com" title="请提出您宝贵的意见">意见反馈</a>
<?php }else{ ?>
	<a href="/login">登陆</a>
<?php } ?>
	</div>
</header>
