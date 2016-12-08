<table class="table table-striped">

    <thead>
        <tr>
            <th>Symbol</th>
            <th>Name</th>
            <th>Shares</th>
            <th>Price</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
<?php foreach ($positions as $position): ?>

    <tr align="left">
        <td><?= $position["symbol"] ?></td>
        <td><?= $position["name"] ?></td>
        <td><?= $position["shares"] ?></td>
        <td><?= $position["price"] ?></td>
        <td><?= number_format(($position["total"]), 2, '.', ',') ?></td>
    </tr>

<?php endforeach ?>
    </tbody>
</table>