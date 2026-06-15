<?php
require_once '../functions.php';
redirect_if_not_logged_in();

$subscribers = get_subscribers();

header('Content-Type: text/csv; charset=UTF-8');
header('Content-Disposition: attachment; filename="subscribers_' . date('Y-m-d') . '.csv"');

$out = fopen('php://output', 'w');
fputcsv($out, ['#', 'Email', 'Status', 'Subscribed On']);

foreach ($subscribers as $i => $sub) {
    fputcsv($out, [
        $i + 1,
        $sub['email'],
        $sub['status'],
        $sub['created_at']
    ]);
}

fclose($out);
exit;
