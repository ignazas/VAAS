-- questionnaire
CREATE TABLE IF NOT EXISTS `practice` (
  `id` int(11) NOT NULL auto_increment,

  `weight` int not null default 0,
  `no` int null,
  `phase_no` int NOT null DEFAULT 1,
  `title` varchar(300) NOT NULL default '',

  `flight_with_instructor_count` int not null default 0,
  `flight_with_instructor_time` time not null default '00:00:00',

  `flight_individual_count` int not null default 0,
  `flight_individual_time` time not null default '00:00:00',

  `flight_box_count` int not null default 0,
  `flight_box_time` time not null default '00:00:00',

  `flight_zone_count` int not null default 0,
  `flight_zone_time` time not null default '00:00:00',

  `flight_route_count` int not null default 0,
  `flight_route_time` time not null default '00:00:00',

  `briefing` time not null default '00:00:00',

  `description` varchar(2000) NOT NULL default '',
  PRIMARY KEY  (`id`)
) CHARACTER SET utf8 COLLATE utf8_lithuanian_ci;

INSERT INTO practice
(`weight`, `no`, `phase_no`, `title`,
 `flight_with_instructor_count`, `flight_with_instructor_time`, `flight_individual_count`, `flight_individual_time`, `flight_box_count`, `flight_box_time`, `flight_zone_count`, `flight_zone_time`, `flight_route_count`, `flight_route_time`,
 `briefing`, `description`)
VALUES
(-1, null, 1, 'Supažindinimas su sklandytuvu ir avarinių situacijų procedūromis',
 0, '00:00:00', 0, '00:00:00', 0, '00:00:00', 0, '00:00:00', 0, '00:00:00',
 '00:30:00', 'Susipažinimas su sklandytuvu. Sklandytuvo techninės savybės, pilotų kabina, vairai, sparno mechanizacijos, lyno atleidimas, važiuoklė. Avarinių situacijų procedūros, parašiuto naudojimas, sklandytuvo palikimas ore.');

INSERT INTO practice
(`weight`, `no`, `phase_no`, `title`,
 `flight_with_instructor_count`, `flight_with_instructor_time`, `flight_individual_count`, `flight_individual_time`, `flight_box_count`, `flight_box_time`, `flight_zone_count`, `flight_zone_time`, `flight_route_count`, `flight_route_time`,
 `briefing`, `description`)
VALUES
(0, null, 1, 'Pasiruošimas skrydžiui ir balansavimo treniruotė sklandytuve',
 0, '00:00:00', 0, '00:00:00', 0, '00:00:00', 0, '00:00:00', 0, '00:00:00',
 '00:30:00', 'Pasiruošimas skrydžiui, reikalingi dokumentai, įrangos patikrinimas, saugos diržų ir sėdynės reguliavimas. Treniruotė sklandytuve, balansavimas, eleronų pagalba, stebint horizontą, kai sklandytuvas stovi prieš vėją.');

INSERT INTO practice
(`weight`, `no`, `phase_no`, `title`,
 `flight_with_instructor_count`, `flight_with_instructor_time`, `flight_individual_count`, `flight_individual_time`, `flight_box_count`, `flight_box_time`, `flight_zone_count`, `flight_zone_time`, `flight_route_count`, `flight_route_time`,
 `briefing`, `description`)
VALUES
(1, 1, 1, 'Pirminė patirtis ore',
 1, '00:25:00', 0, '00:00:00', 0, '00:00:00', 1, '00:25:00', 0, '00:00:00',
 '00:00:00', 'Supažindinti mokinį su sklandytuvu skrendant ir skraidymų vietove. Apsižvalgymo procedūros.');

INSERT INTO practice
(`weight`, `no`, `phase_no`, `title`,
 `flight_with_instructor_count`, `flight_with_instructor_time`, `flight_individual_count`, `flight_individual_time`, `flight_box_count`, `flight_box_time`, `flight_zone_count`, `flight_zone_time`, `flight_route_count`, `flight_route_time`,
 `briefing`, `description`)
VALUES
(2, 2, 1, 'Supažindinimas su sklandytuvo valdymu ore',
 2, '00:50:00', 0, '00:00:00', 0, '00:00:00', 2, '00:50:00', 0, '00:00:00',
 '00:00:00', 'Tiesus sklendimas, pokrypis, polinkis, posvyris, veiksmai vairais, skridimo greitis, vizuali orientacija, apžvalga, sklendimas ratu.');

INSERT INTO practice
(`weight`, `no`, `phase_no`, `title`,
 `flight_with_instructor_count`, `flight_with_instructor_time`, `flight_individual_count`, `flight_individual_time`, `flight_box_count`, `flight_box_time`, `flight_zone_count`, `flight_zone_time`, `flight_route_count`, `flight_route_time`,
 `briefing`, `description`)
VALUES
(3, 3, 1, 'Mokymasis kilti išvelkant lėktuvu (antžeminiu išvilktuvu), valdymas ore.',
 10, '01:20:00', 0, '00:00:00', 10, '01:20:00', 0, '00:00:00', 0, '00:00:00',
 '00:00:00', 'Mokymasis kilti išvelkant lėktuvu (antžeminiu išvilktuvu), atsikabinimas, sklendimas ratu, maršruto skaičiavimas, posūkiai, tūpimo skaičiavimas, tūpimas.');

INSERT INTO practice
(`weight`, `no`, `phase_no`, `title`,
 `flight_with_instructor_count`, `flight_with_instructor_time`, `flight_individual_count`, `flight_individual_time`, `flight_box_count`, `flight_box_time`, `flight_zone_count`, `flight_zone_time`, `flight_route_count`, `flight_route_time`,
 `briefing`, `description`)
VALUES
(4, 4, 1, 'Kilimo tobulinimas, tūpimas pučiant priešiniam ir šoniniam vėjui.',
 8, '01:05:00', 0, '00:00:00', 8, '01:05:00', 0, '00:00:00', 0, '00:00:00',
 '00:00:00', 'Tupdymo mokymas: greitis, aukštis, artėjimas, nuonaša, išlyginimas, išlaikymas. Sparno mechanizacijos naudojimas. Kilimas ir tūpimas esant šoniniam vėjui.');

INSERT INTO practice
(`weight`, `no`, `phase_no`, `title`,
 `flight_with_instructor_count`, `flight_with_instructor_time`, `flight_individual_count`, `flight_individual_time`, `flight_box_count`, `flight_box_time`, `flight_zone_count`, `flight_zone_time`, `flight_route_count`, `flight_route_time`,
 `briefing`, `description`)
VALUES
(5, 5, 1, 'Skrydžiai užklijuotais aukščio arba greičio prietaisais.',
 2, '00:16:00', 0, '00:00:00', 2, '00:16:00', 0, '00:00:00', 0, '00:00:00',
 '00:00:00', 'Vienas skrydis atliekamas užklijuotu aukštimačiu, kitas greitimačio.');

INSERT INTO practice
(`weight`, `no`, `phase_no`, `title`,
 `flight_with_instructor_count`, `flight_with_instructor_time`, `flight_individual_count`, `flight_individual_time`, `flight_box_count`, `flight_box_time`, `flight_zone_count`, `flight_zone_time`, `flight_route_count`, `flight_route_time`,
 `briefing`, `description`)
VALUES
(6, 6, 1, 'Skrydžiai išvelkant lėktuvu, kylant, leidžiantis ir atliekant posūkius (kreiva zona).',
 2, '00:50:00', 0, '00:00:00', 0, '00:00:00', 2, '00:50:00', 0, '00:00:00',
 '00:00:00', 'Mokymasis kilti, skristi horizontaliai ir leistis išvelkant lėktuvu. Skridimas aukščiau ir žemiau “srauto” (valkties srautu). Atsikabinus zonoje: spiralės, slydimas, sklendimas minimaliais greičiais, smuka, suktukas, išvedimas iš suktuko.');

INSERT INTO practice
(`weight`, `no`, `phase_no`, `title`,
 `flight_with_instructor_count`, `flight_with_instructor_time`, `flight_individual_count`, `flight_individual_time`, `flight_box_count`, `flight_box_time`, `flight_zone_count`, `flight_zone_time`, `flight_route_count`, `flight_route_time`,
 `briefing`, `description`)
VALUES
(7, 7, 1, 'Pilotavimo klaidų taisymas.',
 6, '00:48:00', 0, '00:00:00', 6, '00:48:00', 0, '00:00:00', 0, '00:00:00',
 '00:00:00', 'Klaidos kylant, velkantis paskui lėktuvą, skrendant ratu, skaičiuojant tūpimą, tūpiant. Išvilkimo lyno trūkimas, savaiminis atsikabinimas. Klaidų taisymas.');

INSERT INTO practice
(`weight`, `no`, `phase_no`, `title`,
 `flight_with_instructor_count`, `flight_with_instructor_time`, `flight_individual_count`, `flight_individual_time`, `flight_box_count`, `flight_box_time`, `flight_zone_count`, `flight_zone_time`, `flight_route_count`, `flight_route_time`,
 `briefing`, `description`)
VALUES
(8, 8, 1, 'Pilotavimo įgūdžių tobulinimas ir "šlifavimas" prieš savarankišką skrydį.',
 10, '01:20:00', 0, '00:00:00', 10, '01:20:00', 0, '00:00:00', 0, '00:00:00',
 '00:00:00', 'Kartojami visi skrydžio elementai. Skrydis ratu, užėjimas tūpimui ir tūpimas.');

INSERT INTO practice
(`weight`, `no`, `phase_no`, `title`,
 `flight_with_instructor_count`, `flight_with_instructor_time`, `flight_individual_count`, `flight_individual_time`, `flight_box_count`, `flight_box_time`, `flight_zone_count`, `flight_zone_time`, `flight_route_count`, `flight_route_time`,
 `briefing`, `description`)
VALUES
(9, 9, 1, 'Supažindinamasis tūpimas į aikštelę, pasirinktą iš oro.',
 1, '00:30:00', 0, '00:00:00', 1, '00:30:00', 0, '00:00:00', 0, '00:00:00',
 '00:00:00', 'Susipažinimas su esamomis aikštelėmis aerodromo prieigose ir tūpimas į vieną iš jų.');

INSERT INTO practice
(`weight`, `no`, `phase_no`, `title`,
 `flight_with_instructor_count`, `flight_with_instructor_time`, `flight_individual_count`, `flight_individual_time`, `flight_box_count`, `flight_box_time`, `flight_zone_count`, `flight_zone_time`, `flight_route_count`, `flight_route_time`,
 `briefing`, `description`)
VALUES
(10, 10, 1, 'Galutinis pilotavimo įgūdžių patikrinimas prieš pirmą savarankišką skrydį.',
 3, '00:24:00', 0, '00:00:00', 3, '00:24:00', 0, '00:00:00', 0, '00:00:00',
 '00:00:00', 'Skrydžių metu tikrinami visi skrydžio ratu elementai, apžvalga ir orientacija, radijo ryšys. Tinkamas sklandytuvo eksploatavimas. Pastaba: mokinio pasiruošimą atlikti pirmą savarankišką skrydį įvertina instruktorius, savo sprendimą įrašydamas mokinio skraidymo knygelėje.');

INSERT INTO practice
(`weight`, `no`, `phase_no`, `title`,
 `flight_with_instructor_count`, `flight_with_instructor_time`, `flight_individual_count`, `flight_individual_time`, `flight_box_count`, `flight_box_time`, `flight_zone_count`, `flight_zone_time`, `flight_route_count`, `flight_route_time`,
 `briefing`, `description`)
VALUES
(11, 11, 1, 'Pirmas savarankiškas skrydis.',
 1, '00:08:00', 2, '00:16:00', 3, '00:24:00', 0, '00:00:00', 0, '00:00:00',
 '00:00:00', 'Atliekami 1 kontrolinis ir 2 savarankiški skrydžiai ratu. Pastaba: skrydžiai atliekami palankiomis skrydžio sąlygomis.');

 -- 2 etapas

INSERT INTO practice
(`weight`, `no`, `phase_no`, `title`,
 `flight_with_instructor_count`, `flight_with_instructor_time`, `flight_individual_count`, `flight_individual_time`, `flight_box_count`, `flight_box_time`, `flight_zone_count`, `flight_zone_time`, `flight_route_count`, `flight_route_time`,
 `briefing`, `description`)
VALUES
(12, 12, 2, 'Pilotavimo įgūdžių įtvirtinimas.',
 4, '00:32:00', 12, '01:36:00', 16, '02:08:00', 0, '00:00:00', 0, '00:00:00',
 '00:00:00', 'Atliekami skrydžiai ratu, tobulinami skrydžio ratu elementai. *Pastaba: tikrinimą atlieka instruktorius savo nuožiūra ir nustato kontrolinių ir savarankiškų skrydžių skaičių.');

INSERT INTO practice
(`weight`, `no`, `phase_no`, `title`,
 `flight_with_instructor_count`, `flight_with_instructor_time`, `flight_individual_count`, `flight_individual_time`, `flight_box_count`, `flight_box_time`, `flight_zone_count`, `flight_zone_time`, `flight_route_count`, `flight_route_time`,
 `briefing`, `description`)
VALUES
(13, 13, 2, 'Skrydis į zoną.',
 1, '00:25:00', 2, '00:50:00', 0, '00:00:00', 3, '01:15:00', 0, '00:00:00',
 '00:00:00', 'Pirmas skrydis - kontrolinis, kiti - savarankiški. Atliekamos spiralės į kairę ir į dešinę 30° ir 45° posvyriu, vairų kaita, smuka, įvedimas į suktuką skrendant tiesiai ir spiralėje.');

INSERT INTO practice
(`weight`, `no`, `phase_no`, `title`,
 `flight_with_instructor_count`, `flight_with_instructor_time`, `flight_individual_count`, `flight_individual_time`, `flight_box_count`, `flight_box_time`, `flight_zone_count`, `flight_zone_time`, `flight_route_count`, `flight_route_time`,
 `briefing`, `description`)
VALUES
(14, 14, 2, 'Skrydis į zoną, tūpimas į aikštelę, pasirinktą iš oro.',
 1, '00:40:00', 0, '00:00:00', 0, '00:00:00', 1, '00:40:00', 0, '00:00:00',
 '00:00:00', 'Skrydžio į zoną metu atliekama: suktukas (į abi puses po vieną viją), spiralės, smuka, supažindinama su skriejimo pagrindais, tupiama į aikštelę pasirinktą iš oro.');

INSERT INTO practice
(`weight`, `no`, `phase_no`, `title`,
 `flight_with_instructor_count`, `flight_with_instructor_time`, `flight_individual_count`, `flight_individual_time`, `flight_box_count`, `flight_box_time`, `flight_zone_count`, `flight_zone_time`, `flight_route_count`, `flight_route_time`,
 `briefing`, `description`)
VALUES
(15, 15, 2, 'Skrydžių pagal prietaisus pagrindai.',
 1, '00:25:00', 0, '00:00:00', 0, '00:00:00', 1, '00:25:00', 0, '00:00:00',
 '00:00:00', 'Orientavimasis pagal prietaisus, manevrai, prietaisų stebėjimas, tiesus sklendimas, prietaisų apžvalgos tvarka, posūkiai įvairiais posvyriais.');

INSERT INTO practice
(`weight`, `no`, `phase_no`, `title`,
 `flight_with_instructor_count`, `flight_with_instructor_time`, `flight_individual_count`, `flight_individual_time`, `flight_box_count`, `flight_box_time`, `flight_zone_count`, `flight_zone_time`, `flight_route_count`, `flight_route_time`,
 `briefing`, `description`)
VALUES
(16, 16, 2, 'Skrydis maršrutu.',
 1, '00:40:00', 1, '00:40:00', 0, '00:00:00', 0, '00:00:00', 2, '01:20:00',
 '00:00:00', 'Supažindinimas su skraidymo rajonu (apylinkėmis), sklandytuvo vietos nustatymas, mokymas skrieti maršrute, aikštelės pasirinkimas iš oro ir tūpimas į ją, aikštelės įvertinimas. Skrydžio aptarimas. Vienas skridimas su instruktoriumi, kitas savarankiškas.');

INSERT INTO practice
(`weight`, `no`, `phase_no`, `title`,
 `flight_with_instructor_count`, `flight_with_instructor_time`, `flight_individual_count`, `flight_individual_time`, `flight_box_count`, `flight_box_time`, `flight_zone_count`, `flight_zone_time`, `flight_route_count`, `flight_route_time`,
 `briefing`, `description`)
VALUES
(17, 17, 2, 'Savarankiškas skrydis maršrutu.',
 0, '00:00:00', 1, '01:00:00', 0, '00:00:00', 0, '00:00:00', 1, '01:00:00',
 '00:00:00', 'Skrydis instruktoriaus nurodytu maršrutu. *Pastaba: Jeigu su instruktoriumi - min. 100 km; jeigu savarankiškai - min. 50 km ir turi būti pravestos visos išvardintos mokymo temos: skrydžio planavimas, navigacija skrydžio metu, maršrutinio skrydžio būdai.');

-- answers
CREATE TABLE IF NOT EXISTS `practice_data` (
  `id` int(11) NOT NULL auto_increment,

  `user_id` int(11) NOT NULL,
  `instructor_id` int(11) NOT NULL,
  `practice_id` int(11) NOT NULL,
  `aircraft_id` int(11) NOT NULL,
  `date` DATE NOT NULL,

  `count` int not null default 1,
  `time` time not null,

  `comments` varchar(2000) NOT NULL default '',
  PRIMARY KEY  (`id`)
) CHARACTER SET utf8 COLLATE utf8_lithuanian_ci;
