{_word}                                     <?php include($this->templates["word"]); ?>
{@word}                                     <?php echo($this->parameters['word']); ?>
{$word}                                     <?php echo($word); ?>
{#word}                                     <?php echo(WORD); ?>
{foreach @word as $key => $value}           <?php foreach($this->container['word']) as $key => $value) { ?>
{foreach $word as $value}                   <?php foreach($word as $value) { ?>
{/foreach}                                  <?php } ?>
