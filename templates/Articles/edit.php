<h1>edit Article</h1>
<?php
    echo $this->Form->create($article);
    echo $this->Form->control('title');
    echo $this->Form->control('body', ['rows' => '3']);
    
    //Replacing next line for new tags implementation
    // echo $this->Form->control('tags._ids', ['options' => $tags]);
    echo $this->Form->control('tag_string', ['type' => 'text']);

    echo $this->Form->button(__('Update Article'));
    echo $this->Form->end();
?>