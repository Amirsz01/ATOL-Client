<?php

namespace Grokhotov\ATOL\Object;

class PaymentObject
{
    public const PAYMENT_OBJECT_COMM_NOMARK_NOEXCISE = 1; //о реализуемом товаре, за исключением подакцизного товара и товара, подлежащего маркировке средствами идентификации (наименование и иные сведения, описывающие товар)
    public const PAYMENT_OBJECT_COMM_NOMARK_EXCISE = 2; //о реализуемом подакцизном товаре, за исключением товара, подлежащего маркировке средствами идентификации (наименование и иные сведения, описывающие товар)
    public const PAYMENT_OBJECT_JOB = 3;
    public const PAYMENT_OBJECT_SERVICE = 4;
    public const PAYMENT_OBJECT_BET = 5;
    public const PAYMENT_OBJECT_BETWIN = 6;
    public const PAYMENT_OBJECT_LOTERY = 7;
    public const PAYMENT_OBJECT_LOTERYWIN = 8;
    public const PAYMENT_OBJECT_COPYRIGHTS = 9;
    public const PAYMENT_OBJECT_PREPAY = 10; //and credit, avance, zadatok,
    public const PAYMENT_OBJECT_COMISSION = 11;
    public const PAYMENT_OBJECT_PENY = 12; //штраф, комиссия, вознаграждение, бонус
    public const PAYMENT_OBJECT_ENIGMA = 13; // о предмете расчета, не относящемуся к предметам расчета, которым может быть присвоено значение от «1» до «11» и от «14» до «26»
    public const PAYMENT_OBJECT_REALTY = 14; //о передаче имущественных прав
    public const PAYMENT_OBJECT_VNEREL = 15; // о внереализационном доходе
    public const PAYMENT_OBJECT_ENIGMA2 = 16; // о суммах расходов, платежей и взносов, указанных в подпунктах 2 и 3 пункта Налогового кодекса Российской Федерации, уменьшающих сумму налога
    public const PAYMENT_OBJECT_TORGSBOR = 17; // о суммах уплаченного торгового сбора
    public const PAYMENT_OBJECT_KURORT = 18; // о курортном сборе
    public const PAYMENT_OBJECT_ZALOG = 19; //  о залоге
    public const PAYMENT_OBJECT_ENIGMA3 = 20; //   о суммах произведенных расходов в соответствии со статьей 346.16 Налогового кодекса Российской Федерации, уменьшающих доход
    public const PAYMENT_OBJECT_STRAH_IP = 21; //   о страховых взносах на обязательное пенсионное страхование, уплачиваемых ИП, не производящими выплаты и иные вознаграждения физическим лицам
    public const PAYMENT_OBJECT_STRAH_IP2 = 22; //   о страховых взносах на обязательное пенсионное страхование, уплачиваемых организациями и ИП, производящими выплаты и иные вознаграждения физическим лицам
    public const PAYMENT_OBJECT_STRAH_MED = 23; //   о страховых взносах на обязательное медицинское страхование, уплачиваемых ИП, не производящими выплаты и иные вознаграждения физическим лицам
    public const PAYMENT_OBJECT_STRAH_MED2 = 24; //   о страховых взносах на обязательное медицинское страхование, уплачиваемые организациями и ИП, производящими выплаты и иные вознаграждения физическим лицам
    public const PAYMENT_OBJECT_STRAH_TRUD = 25; //   о страховых взносах на обязательное социальное страхование на случай временной нетрудоспособности и в связи с материнством, на обязательное социальное страхование от несчастных случаев на производстве и профессиональных заболеваний
    public const PAYMENT_OBJECT_CASINO = 26; //   о приеме и выплате денежных средств при осуществлении казино и залами игровых автоматов расчетов с использованием обменных знаков игорного заведения
    public const PAYMENT_OBJECT_BANKAGENT = 27; //   о выдаче денежных средств банковским платежным агентом
    public const PAYMENT_OBJECT_COMM_EXCISE_MARK_HASNOMARK = 30; //   о реализуемом подакцизном товаре, подлежащем маркировке средством идентификации, не имеющем кода маркировки
    public const PAYMENT_OBJECT_COMM_EXCISE_MARK_HAVEMARK = 31; //    о реализуемом подакцизном товаре, подлежащем маркировке средством идентификации, имеющем код маркировки
    public const PAYMENT_OBJECT_COMM_NOEXCISE_MARK_HASNOMARK = 32; //     о реализуемом товаре, подлежащем маркировке средством идентификации, не имеющем кода маркировки, за исключением подакцизного товара
    public const PAYMENT_OBJECT_COMM_NOEXCISE_MARK_HAVEMARK = 33; //     о реализуемом товаре, подлежащем маркировке средством идентификации, имеющем код маркировки, за исключением подакцизного товара
}