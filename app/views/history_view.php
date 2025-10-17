<?php require_once __DIR__ . '/../common/function.php'; 
    $subjectLabels = [
        'kanji'   => '国語',
        'math'    => '算数',
        'science' => '理科',
        'social'  => '社会'
    ];

?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>学習履歴・分析 | まなびの森</title>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
body {
    font-family: "Yu Gothic", sans-serif;
    background: #f3f7ff;
    margin: 0;
    padding: 0;
}

.container {
    width: 90%;
    max-width: 800px;
    background: white;
    margin: 40px auto;
    padding: 30px;
    border-radius: 16px;
    box-shadow: 0 6px 15px rgba(0,0,0,0.1);
}

h2 {
    color: #333;
    margin-bottom: 20px;
    border-left: 6px solid #3b82f6;
    padding-left: 10px;
}

.daily {
    background: #f9fafb;
    border-radius: 10px;
    padding: 15px;
    margin-bottom: 20px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.05);
}

.btn-review {
    background: #3b82f6;
    color: #fff;
    border: none;
    border-radius: 6px;
    padding: 8px 16px;
    cursor: pointer;
    margin-top: 10px;
}

.btn-review:hover {
    background: #2563eb;
}

canvas {
    width: 100%;
    max-width: 600px;
    margin: 20px auto;
    display: block;
}

.back-link {
    display: block;
    margin-top: 20px;
    text-align: center;
    color: #3b82f6;
    text-decoration: none;
}

</style>
</head>
<body>
<div class="container">
    <h2>学習履歴</h2>
    <?php if (!empty($dailyStats)): ?>
        <?php foreach ($dailyStats as $date => $subjects): ?>
            <div class="daily">
                <h3><?= h($date) ?></h3>
                <?php foreach ($subjects as $subject => $stats): ?>
                    <?php
                        $correct = $stats['correct'] ?? 0;
                        $wrong = $stats['wrong'] ?? 0;
                        $rate = ($correct + $wrong) > 0 ? round($correct / ($correct + $wrong) * 100, 2) : 0;
                    ?>
                    <p>
                        科目: <?= h($subjectLabels[$subject] ?? $subject) ?><br>
                        正解: <?= $correct ?>　
                        不正解: <?= $wrong ?>　
                        正答率: <?= $rate ?>%
                    </p>
                    <?php if (!empty($stats['quizzes'])): ?>
                        <button class="btn-review" onclick="alert('復習機能は後で実装します');">間違えた問題を復習</button>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>まだ学習履歴がありません。</p>
    <?php endif; ?>

    <h2>科目別正答率</h2>
    <canvas id="subjectChart"></canvas>

    <a href="/studystep/studyapp-1/public/mypage.php" class="back-link">← マイページに戻る</a>
</div>

<script>
// PHPからデータをJSに渡す（安全に処理）
const subjects = <?= json_encode(array_map(function($key) use ($subjectLabels) {
    return $subjectLabels[$key] ?? $key;
}, array_keys($subjectStats))) ?>;

const accuracies = <?= json_encode(array_map(function($s) {
    $correct = $s['correct'] ?? 0;
    $total = $s['total'] ?? 0;
    return $total > 0 ? round($correct / $total * 100, 2) : 0;
}, $subjectStats)) ?>;

// 棒グラフ描画
new Chart(document.getElementById('subjectChart'), {
    type: 'bar',
    data: {
        labels: subjects,
        datasets: [{
            label: '正答率 (%)',
            data: accuracies,
            backgroundColor: '#3b82f6'
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: { beginAtZero: true, max: 100 }
        }
    }
});
</script>
</body>
</html>
