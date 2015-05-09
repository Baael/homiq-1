czy mógłbyś mi przypomnieć komendę, która reguluje zachowanie IO gdy nie ma komunikacji z aplikacją, domyślnie jest odwzorowanie wejść na wyjścia jak zwykłe przekaźniki, jak to wyłączyć?

IOM.0 ... IOM.9  - wysłanie 1 włącza odwzorowanie 0 wyłącza

----------------------------


sumy kotrolne i inne takie:

pakiet: <;$cmd;$val;$src;$dst;$ser;$type;$crc;>\r\n

do wyliczania sumy crc bieżemy składniki jak w linijce poniżej
hcrc("$cmd"."$val"."$src"."$dst"."$ser"."$type"); //znaczenie kropki w perlu jest w tym wyrażeniu takie samo jak w php

i wyliczamy crc według algorytmu podanego niżej.

Oprócz tego co około 18 sec musimy wysłać następujący pakiet:

<;HB;1;0;yy;serial;s;crc;>\r\n - serial liczba od 1-256 seriale w kolejnych wysłaniach muszą się różnić  crc - wyliczone z podanego algorytmu (nie oczekujemy żadnej odpowiedzi na ten pakiet)



ALGORYTM WYLICZANIA CRC:

our $CRC8INIT=0x00;
our $CRC8POLY=0x18;
our $crc;


our $m_crc;
our $m_byte_count;

sub init_crc8
{
        $crc = 0;
}
sub  return_crc8
{ return $crc; }
sub calc_crc8
{
        my $data=shift;

       $bit_counter = 8;
                do {
                        $feedback_bit = ($crc ^ $data) & 0x01;
                        if ( $feedback_bit == 0x01 ) {

                                $crc = $crc ^ $CRC8POLY;

                        }
                        $crc = ($crc >> 1) & 0x7F;
                        if ($feedback_bit == 0x01 ) {
                                $crc = $crc | 0x80;
                        }
                        $data = $data >> 1;
                        $bit_counter--;

                } while ($bit_counter > 0);


}
sub hcrc{

init_crc8();
$string = shift;
while ($string =~ /(.)/g) {
    calc_crc8(ord($1));
}
}
