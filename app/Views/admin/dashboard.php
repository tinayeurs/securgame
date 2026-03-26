<h1>Administration</h1>
<div class="grid grid-3"><?php foreach($stats as $k=>$v): ?><div class="card"><h3><?= htmlspecialchars(ucfirst($k)) ?></h3><p><?= (int)$v ?></p></div><?php endforeach; ?></div>
