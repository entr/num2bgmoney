<?php
# Convert number to bulgarian text represantation
# Version 1.06 (07-Dec-2006)
#
# Contacts:
#   E-mail: georgi@unixsol.org
#   WWW   : http://georgi.unixsol.org/
#   Source: http://georgi.unixsol.org/programs/egn.php
#
# Copyright (c) 2006 Georgi Chorbadzhiyski
# All rights reserved.
#
# Redistribution and use of this script, with or without modification, is
# permitted provided that the following conditions are met:
#
# 1. Redistributions of this script must retain the above copyright
#    notice, this list of conditions and the following disclaimer.
#
#  THIS SOFTWARE IS PROVIDED BY THE AUTHOR ``AS IS'' AND ANY EXPRESS OR IMPLIED
#  WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF
#  MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED.  IN NO
#  EVENT SHALL THE AUTHOR BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
#  SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO,
#  PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS;
#  OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY,
#  WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR
#  OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF
#  ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
#

/* The functions */
$_num0   = array(0 => "нула",1 => "един",2 => "две",3 => "три",4 => "четири",
				 5 => "пет",6 => "шест",7 => "седем",8 => "осем",9 => "девет",
				 10 => "десет", 11 => "единадесет", 12 => "дванадесет");
$_num100 = array(1 => "сто", 2 => "двеста", 3 => "триста");

function num2bgtext($number,$stotinki=false) {
	global $_num0, $_num100;

	$number = (int)$number;

	$_div10 = ($number - $number % 10) / 10;
	$_mod10 = $number % 10;
	$_div100 = ($number - $number % 100) / 100;
	$_mod100 = $number % 100;
	$_div1000 = ($number - $number % 1000) / 1000;
	$_mod1000 = $number % 1000;
	$_div1000000 = ($number - $number % 1000000) / 1000000;
	$_mod1000000 = $number % 1000000;
	$_div1000000000 = ($number - $number % 1000000000) / 1000000000;
	$_mod1000000000 = $number % 1000000000;

	if ($number == 0) {
		return $_num0[$number];
	}
	/* До двайсет */
	if ($number > 0 && $number < 20) {
		if ($stotinki && $number == 1)
			return "една";
		if ($stotinki && $number == 2)
			return "две";
		if ($number == 2)
			return "два";
		return isset($_num0[$number]) ? $_num0[$number] : $_num0[$_mod10]."надесет";
	}
	/* До сто */
	if ($number > 19 && $number < 100) {
		$tmp = ($_div10 == 2) ? "двадесет" : $_num0[$_div10]."десет";
		$tmp = $_mod10 ? $tmp." и ".num2bgtext($_mod10,$stotinki) : $tmp;
		return $tmp;
	}
	/* До хиляда */
	if ($number > 99 && $number < 1000) {
		$tmp = isset($_num100[$_div100]) ? $_num100[$_div100] : $_num0[$_div100]."стотин";
		if (($_mod100 % 10 == 0 || $_mod100 < 20) && $_mod100 != 0) {
			$tmp .= " и";
		}
		if ($_mod100) {
			$tmp .= " ".num2bgtext($_mod100);
		}
		return $tmp;
	}
	/* До милион */
	if ($number > 999 && $number < 1000000) {
		/* Damn bulgarian @#$%@#$% два хиляди is wrong :) */
		$tmp = ($_div1000 == 1) ? "хиляда" :
			   (($_div1000 == 2) ? "две хиляди" : num2bgtext($_div1000)." хиляди");
		$_num0[2] = "два";
		if (($_mod1000 % 10 == 0 || $_mod1000 < 20) && $_mod1000 != 0) {
			if (!(($_mod100 % 10 == 0 || $_mod100 < 20) && $_mod100 != 0)) {
				$tmp .= " и";
			}
		}
		if (($_mod1000 % 10 == 0 || $_mod1000 < 20) && $_mod1000 != 0 && $_mod1000 < 100) {
			$tmp .= " и";
		}
		if ($_mod1000) {
			$tmp .= " ".num2bgtext($_mod1000);
		}
		return $tmp;
	}
	/* Над милион */
	if ($number > 999999 && $number < 1000000000) {
		$tmp = ($_div1000000 == 1) ? "един милион" : num2bgtext($_div1000000)." милиона";
		if (($_mod1000000 % 10 == 0 || $_mod1000000 < 20) && $_mod1000000 != 0) {
			if (!(($_mod1000 % 10 == 0 || $_mod1000 < 20) && $_mod1000 != 0)) {
				if (!(($_mod100 % 10 == 0 || $_mod100 < 20) && $_mod100 != 0)) {
					$tmp .= " и";
				}
			}
		}
		$and = ", ";
		if (($_mod1000000 % 10 == 0 || $_mod1000000 < 20) && $_mod1000000 != 0 && $_mod1000000 < 1000) {
			if (($_mod1000 % 10 == 0 || $_mod1000 < 20) && $_mod1000 != 0 && $_mod1000 < 100) {
				$tmp .= " и";
			}
		}
		if ($_mod1000000) {
			$tmp .= " ".num2bgtext($_mod1000000);
		}
		return $tmp;
	}
	/* Над милиард */
	if ($number > 99999999 && $number <= 2000000000) {
		$tmp = ($_div1000000000 == 1) ? "един милиард" : "";
		$tmp = ($_div1000000000 == 2) ? "два милиарда" : $tmp;
		if ($_mod1000000000) {
			$tmp .= " ".num2bgtext($_mod1000000000);
		}
		return $tmp;
	}
	/* Bye ... */
	return "";
}

function number2lv($number) {
	list($lv, $st) = explode(".", number_format($number,2,".",""));
	$lv = (int)$lv;
	if ($lv >= 2000000000)
		return "Твърде голямо число";
	$text  = num2bgtext($lv);
	$text .= $lv == 1 ? " лев":" лева";
	if ($st <> 0)
		$text = preg_replace("/^един /","",$text);
	if ($st && $st != 0) {
		$sttext = num2bgtext($st,true);
		$text .= " и ".num2bgtext($st,true);
		$text .= $st == 1 ? " стотинка":" стотинки";
	}
	return $text;
}
