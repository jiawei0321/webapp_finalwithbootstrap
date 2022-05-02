<?php
//horoscope
function starsign($month, $day)
{
  if (($month == 3 && $day > 20) || ($month == 4 && $day < 20)) {
    echo "Aries";
  } elseif (($month == 4 && $day > 19) || ($month == 5 && $day < 21)) {
    echo "Taurus";
  } elseif (($month == 5 && $day > 20) || ($month == 6 && $day < 21)) {
    echo "Gemini";
  } elseif (($month == 6 && $day > 20) || ($month == 7 && $day < 23)) {
    echo "Cancer";
  } elseif (($month == 7 && $day > 22) || ($month == 8 && $day < 23)) {
    echo "Leo";
  } elseif (($month == 8 && $day > 22) || ($month == 9 && $day < 23)) {
    echo "Virgo";
  } elseif (($month == 9 && $day > 22) || ($month == 10 && $day < 23)) {
    echo "Libra";
  } elseif (($month == 10 && $day > 22) || ($month == 11 && $day < 22)) {
    echo "Scorpio";
  } elseif (($month == 11 && $day > 21) || ($month == 12 && $day < 22)) {
    echo "Sagittarius";
  } elseif (($month == 12 && $day > 21) || ($month == 1 && $day < 20)) {
    echo "Capricorn";
  } elseif (($month == 1 && $day > 19) || ($month == 2 && $day < 19)) {
    echo "Aquarius";
  } elseif (($month == 2 && $day > 18) || ($month == 3 && $day < 21)) {
    echo "Pisces";
  }
}
//gender
function checkgender($gender)
{
  if ($gender == 'male') {
    //show man
    echo "<i class='fa fa-mars fa-2x'>";
    echo "</i>";
  } else if ($gender == 'female') {
    //show girl
    echo "<i class='fa fa-venus fa-2x'>";
    echo "</i>";
  } else if ($gender == 'other') {
    //show other
    echo "<i class='fa fa-genderless fa-2x'>";
    echo "</i>";
  }
}

?>
