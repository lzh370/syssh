<span class="pagination">
	<?=$this->config->user_item('pagination/start')+1?>-<?=$this->config->user_item('pagination/rows')<$this->config->user_item('pagination/items')?$this->config->user_item('pagination/rows'):$this->config->user_item('pagination/start')+$this->config->user_item('pagination/items')?>/<?=$this->config->user_item('pagination/rows')?>
	<button type="button" <?php if($this->config->user_item('pagination/start')==0){ ?>disabled="disabled"<?php }else{ ?>target-page-start="0"<?php } ?>>&lt;&lt;</button>
	<button type="button" <?php if($this->config->user_item('pagination/start')==0){ ?>disabled="disabled"<?php }else{ ?>target-page-start="<?=$this->config->user_item('pagination/start')-$this->config->user_item('pagination/items')?>"<?php } ?>>&nbsp;&lt;&nbsp;</button>
	<button type="button" <?php if($this->config->user_item('pagination/start')+$this->config->user_item('pagination/items')>=$this->config->user_item('pagination/rows')){ ?>disabled="disabled"<?php }else{ ?>target-page-start="<?=$this->config->user_item('pagination/start')+$this->config->user_item('pagination/items')?>"<?php } ?>>&nbsp;&gt;&nbsp;</button>
	<button type="button" <?php if($this->config->user_item('pagination/start')+$this->config->user_item('pagination/items')>=$this->config->user_item('pagination/rows')){ ?>disabled="disabled"<?php }else{ ?>target-page-start="<?=(ceil($this->config->user_item('pagination/rows')/$this->config->user_item('pagination/items'))-1)*$this->config->user_item('pagination/items')?>"<?php } ?>>&gt;&gt;</button>
</span>