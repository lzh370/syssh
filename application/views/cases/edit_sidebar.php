<button type="submit" name="submit[project]" class="major">保存</button>

<?php  if($this->user->isLogged('manager') && in_array('等待立案审核',$labels) && $project['type']==='cases'){ ?>
		<button type="submit" name="submit[review]" class="major">立案审核</button>
<?php  }//TODO: 批量替换多余的空格?>
<?php  if($this->user->isLogged('finance') && in_array('已申请归档',$labels) && !in_array('通过财务审核',$labels)){ ?>
		<button type="submit" name="submit[review_finance]" class="major">财务审核</button>
<?php  }?>
<?php  if($this->user->isLogged('admin') && in_array('已申请归档',$labels) && !in_array('通过信息审核',$labels)){ ?>
		<button type="submit" name="submit[review_info]" class="major">信息审核</button>
<?php  }?>
<?php  if($this->user->isLogged('manager') && in_array('已申请归档',$labels) && !in_array('通过主管审核',$labels)){ ?>
		<button type="submit" name="submit[review_manager]" class="major">主管审核</button>
<?php  }?>
<?php  if($this->user->isLogged('admin') && in_array('已申请归档',$labels) && in_array('通过财务审核',$labels) && in_array('通过信息审核',$labels) && in_array('通过主管审核',$labels) && !in_array('案卷已归档',$labels)){ ?>
		<button type="submit" name="submit[file]" class="major">实体归档</button>
<?php  }?>
<?php  if($project['type']==='query'){ ?>
		<button type="submit" name="submit[new_case]" class="major">立案</button>
		<button type="submit" name="submit[file]" class="major">归档</button>
<?php  } ?>
<?php if(!in_array('已申请归档',$labels) && !in_array('案卷已归档',$labels) &&
	in_array('客户已锁定',$labels) &&
	in_array('职员已锁定',$labels) &&
	in_array('费用已锁定',$labels)
){ ?>
		<button type="submit" name="submit[apply_file]" class="major">申请归档</button>
<?php  }?>
<select name="labels[]" class="chosen allow-new" data-placeholder="标签" multiple="multiple">
	<?=options($this->project->getAllLabels(),$labels)?>
</select>