<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Результат анализа</title>
    <link rel="stylesheet" href="styles/styles.css">
</head>

<body>
    <div class="container">
        <h1>Результат анализа текста</h1>
        <?php
        //проверка данных, отправлен ли текст и что текст не пустой
        if (isset($_POST['data']) && trim($_POST['data']) != '') {
            $text = $_POST['data'];
            //выводим
            echo '<div class="src_text"><i>' . htmlspecialchars($text) . '</i></div>';

            //подсчет количества символов
            $num_chars = mb_strlen($text);
            //для подсчета символов, находит длину строки

            //подсчет количества букв (строчные и заглавные)
            $num_letters = preg_match_all('/[a-zA-Zа-яА-ЯёЁ]/u', $text);
            $num_lowercase = preg_match_all('/[a-zа-яё]/u', $text);
            $num_uppercase = preg_match_all('/[A-ZА-ЯЁ]/u', $text);
            //preg_match_all выполняет поиск по шаблону регулярного выражения во всей строке и возвращает все найденные совпадения

            //подсчет количества цифр
            $num_digits = preg_match_all('/\d/u', $text);

            //подсчет количества знаков препинания
            $num_punctuation = preg_match_all('/[.,!?;:"\'()\[\]{}\-]/u', $text);

            //подсчет количества слов
            $num_words = str_word_count(mb_strtolower($text), 0, 'абвгдеёжзийклмнопрстуфхцчшщъыьэюя');

            //частотный анализ символов без учета регистра
            $symbs = array_count_values(mb_str_split(mb_strtolower($text)));
            //array_count_values подсчитывает, сколько раз встречается каждый символ в тексте
            //mb_str_split разбивает строку на массив символов. Здесь текст также приводится к нижнему регистру, чтобы считать а и А как один символ

            //частотный анализ слов с учетом регистра
            $words = array_count_values(str_word_count(mb_strtolower($text), 1, 'абвгдеёжзийклмнопрстуфхцчшщъыьэюя'));
            ksort($words);
            //сортирует массив по алфавиту.

            echo '<table>';
            echo "<tr><td>Количество символов</td><td>$num_chars</td></tr>";
            echo "<tr><td>Количество букв</td><td>$num_letters</td></tr>";
            echo "<tr><td>Строчные буквы</td><td>$num_lowercase</td></tr>";
            echo "<tr><td>Заглавные буквы</td><td>$num_uppercase</td></tr>";
            echo "<tr><td>Знаки препинания</td><td>$num_punctuation</td></tr>";
            echo "<tr><td>Цифры</td><td>$num_digits</td></tr>";
            echo "<tr><td>Слова</td><td>$num_words</td></tr>";
            echo '</table>';

            //вывод частотного анализа символов
            echo '<h2>Частота символов:</h2><table>';
            foreach ($symbs as $symbol => $count) {
                $display_symbol = htmlspecialchars($symbol);
                echo "<tr><td>'$display_symbol'</td><td>$count</td></tr>";
            }
            echo '</table>';

            //вывод частотного анализа слов
            echo '<h2>Частота слов:</h2><table>';
            foreach ($words as $word => $count) {
                echo "<tr><td>$word</td><td>$count</td></tr>";
            }
            echo '</table>';

            echo '<a href="index.html" class="button">Другой анализ</a>';
        } else {
            echo '<div class="src_error">Нет текста для анализа</div>';
        }
        ?>

    </div>
</body>

</html>