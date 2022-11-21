
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `DbNews`
--
CREATE DATABASE IF NOT EXISTS `DbNews` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `DbNews`;

-- --------------------------------------------------------

--
-- Table structure for table `TbArticleAuthors`
--

CREATE TABLE `TbArticleAuthors` (
  `Id` int(11) NOT NULL,
  `IdArticle` int(11) NOT NULL,
  `IdUser` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `TbArticleAuthors`
--

INSERT INTO `TbArticleAuthors` (`Id`, `IdArticle`, `IdUser`) VALUES
(3, 15, 3),
(4, 16, 9),
(5, 15, 9),
(6, 19, 10);

-- --------------------------------------------------------

--
-- Table structure for table `TbArticleCategories`
--

CREATE TABLE `TbArticleCategories` (
  `Id` int(11) NOT NULL,
  `IdArticle` int(11) NOT NULL,
  `IdCategory` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `TbArticleCategories`
--

INSERT INTO `TbArticleCategories` (`Id`, `IdArticle`, `IdCategory`) VALUES
(1, 15, 5),
(5, 16, 4),
(2, 16, 5),
(3, 17, 8),
(4, 18, 2),
(6, 19, 5);

-- --------------------------------------------------------

--
-- Table structure for table `TbArticleLike`
--

CREATE TABLE `TbArticleLike` (
  `Id` int(11) NOT NULL,
  `IdArticle` int(11) NOT NULL,
  `IdUser` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `TbArticleLike`
--

INSERT INTO `TbArticleLike` (`Id`, `IdArticle`, `IdUser`) VALUES
(7, 15, 1),
(1, 19, 9),
(2, 19, 10);

-- --------------------------------------------------------

--
-- Table structure for table `TbArticles`
--

CREATE TABLE `TbArticles` (
  `Id` int(11) NOT NULL,
  `Title` text NOT NULL,
  `Summary` text NOT NULL,
  `Content` text NOT NULL,
  `PublishedDate` datetime NOT NULL DEFAULT current_timestamp(),
  `UpdatedDate` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `Published` bit(1) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `TbArticles`
--

INSERT INTO `TbArticles` (`Id`, `Title`, `Summary`, `Content`, `PublishedDate`, `UpdatedDate`, `Published`) VALUES
(15, 'Quod cum ille dixisset et satis disputatum videretur, in oppidum ad Pomponium perreximus omnes.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Simul atque natum animal est, gaudet voluptate et eam appetit ut bonum, aspernatur dolorem ut malum. Addebat etiam se in legem Voconiam iuratum contra eam facere non audere, nisi aliter amicis videretur.', '<p>Quam vellem, inquit, te ad Stoicos inclinavisses! erat enim, si cuiusquam, certe tuum nihil praeter virtutem in bonis ducere. Sed haec ab Antiocho, familiari nostro, dicuntur multo melius et fortius, quam a Stasea dicebantur. Illum mallem levares, quo optimum atque humanissimum virum, Cn. Amicitiae vero locus ubi esse potest aut quis amicus esse cuiquam, quem non ipsum amet propter ipsum? Duo Reges: constructio interrete. Itaque hic ipse iam pridem est reiectus;</p>\r\n<p>Et quae per vim oblatum stuprum volontaria morte lueret inventa est et qui interficeret filiam, ne stupraretur. Nam si amitti vita beata potest, beata esse non potest. Atque omnia quidem scire, cuiuscumque modi sint, cupere curiosorum, duci vero maiorum rerum contemplatione ad cupiditatem scientiae summorum virorum est putandum. Haec non erant eius, qui innumerabilis mundos infinitasque regiones, quarum nulla esset ora, nulla extremitas, mente peragravisset. Perturbationes autem nulla naturae vi commoventur, omniaque ea sunt opiniones ac iudicia levitatis. Non est enim vitium in oratione solum, sed etiam in moribus. Est tamen ea secundum naturam multoque nos ad se expetendam magis hortatur quam superiora omnia. Sed ad bona praeterita redeamus. Nullum inveniri verbum potest quod magis idem declaret Latine, quod Graece, quam declarat voluptas. Hanc se tuus Epicurus omnino ignorare dicit quam aut qualem esse velint qui honestate summum bonum metiantur.</p>\r\n<p>An ea, quae per vinitorem antea consequebatur, per se ipsa curabit? Cuius quidem, quoniam Stoicus fuit, sententia condemnata mihi videtur esse inanitas ista verborum. Illis videtur, qui illud non dubitant bonum dicere -; Tum Piso: Quoniam igitur aliquid omnes, quid Lucius noster? Nunc haec primum fortasse audientis servire debemus. Nec lapathi suavitatem acupenseri Galloni Laelius anteponebat, sed suavitatem ipsam neglegebat;&nbsp;<strong>At multis malis affectus.</strong>&nbsp;Qui si omnes veri erunt, ut Epicuri ratio docet, tum denique poterit aliquid cognosci et percipi. Quae enim dici Latine posse non arbitrabar, ea dicta sunt a te verbis aptis nec minus plane quam dicuntur a Graecis. Tanta vis admonitionis inest in locis; Sed tu, ut dignum est tua erga me et philosophiam voluntate ab adolescentulo suscepta, fac ut Metrodori tueare liberos. Nec enim ille respirat, ante quam emersit, et catuli aeque caeci, prius quam dispexerunt, ac si ita futuri semper essent. Ut enim, inquit, gubernator aeque peccat, si palearum navem evertit et si auri, item aeque peccat, qui parentem et qui servum iniuria verberat. Et quidem illud ipsum non nimium probo et tantum patior, philosophum loqui de cupiditatibus finiendis.</p>\r\n<ol>\r\n<li>Ego quoque, inquit, didicerim libentius si quid attuleris, quam te reprehenderim.</li>\r\n<li>Qui potest igitur habitare in beata vita summi mali metus?</li>\r\n<li>Quis suae urbis conservatorem Codrum, quis Erechthei filias non maxime laudat?</li>\r\n</ol>\r\n<ul>\r\n<li>Id et fieri posse et saepe esse factum et ad voluptates percipiendas maxime pertinere.</li>\r\n<li>Si mala non sunt, iacet omnis ratio Peripateticorum.</li>\r\n</ul>\r\n<p><em>Multoque hoc melius nos veriusque quam Stoici.</em>&nbsp;Istius modi autem res dicere ornate velle puerile est, plane autem et perspicue expedire posse docti et intellegentis viri. Si sapiens, ne tum quidem miser, cum ab Oroete, praetore Darei, in crucem actus est. Nec mihi illud dixeris: Haec enim ipsa mihi sunt voluptati, et erant illa Torquatis. Ut optime, secundum naturam affectum esse possit. Quis nostrum dixerit, quos non pudet ea, quae Stoici aspera dicunt, mala dicere, melius esse turpiter aliquid facere cum voluptate quam honeste cum dolore? Itaque multi, cum in potestate essent hostium aut tyrannorum, multi in custodia, multi in exillo dolorem suum doctrinae studiis levaverunt. Restincta enim sitis stabilitatem voluptatis habet, inquit, illa autem voluptas ipsius restinctionis in motu est.</p>\r\n<h2>Laelius clamores sof&ograve;w ille so lebat Edere compellans gumias ex ordine nostros.</h2>\r\n<p>Hic nihil fuit, quod quaereremus.&nbsp;<em>Polycratem Samium felicem appellabant.</em>&nbsp;Nam et complectitur verbis, quod vult, et dicit plane, quod intellegam;&nbsp;<strong>Confecta res esset.</strong>&nbsp;Quod dicit Epicurus etiam de voluptate, quae minime sint voluptates, eas obscurari saepe et obrui. Id enim volumus, id contendimus, ut officii fructus sit ipsum officium. Quae dici eadem de ceteris virtutibus possunt, quarum omnium fundamenta vos in voluptate tamquam in aqua ponitis. Ita fit illa conclusio non solum vera, sed ita perspicua, ut dialectici ne rationem quidem reddi putent oportere: si illud, hoc; Deque his rebus satis multa in nostris de re publica libris sunt dicta a Laelio. Videamus animi partes, quarum est conspectus illustrior; Sunt autem, qui dicant foedus esse quoddam sapientium, ut ne minus amicos quam se ipsos diligant. Hoc positum in Phaedro a Platone probavit Epicurus sensitque in omni disputatione id fieri oportere. Ergo infelix una molestia, fellx rursus, cum is ipse anulus in praecordiis piscis inventus est?</p>\r\n<dl>\r\n<dt><dfn>A mene tu?</dfn></dt>\r\n<dd>At negat Epicurus-hoc enim vestrum lumen estquemquam, qui honeste non vivat, iucunde posse vivere.</dd>\r\n<dt><dfn>Quo modo?</dfn></dt>\r\n<dd>Istam voluptatem perpetuam quis potest praestare sapienti?</dd>\r\n<dt><dfn>An eiusdem modi?</dfn></dt>\r\n<dd>Quis enim potest ea, quae probabilia videantur ei, non probare?</dd>\r\n</dl>', '2022-10-04 06:42:00', NULL, b'1'),
(16, 'Sin laboramus, quis est, qui alienae modum statuat industriae?', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Expectoque quid ad id, quod quaerebam, respondeas. Cum autem negant ea quicquam ad beatam vitam pertinere, rursus naturam relinquunt.', '<p>Duo Reges: constructio interrete. Illud urgueam, non intellegere eum quid sibi dicendum sit, cum dolorem summum malum esse dixerit.&nbsp;<em>Bonum integritas corporis: misera debilitas.</em>&nbsp;Hic ambiguo ludimur. Qui-vere falsone, quaerere mittimus-dicitur oculis se privasse; Non est igitur summum malum dolor.</p>\r\n<p>Sed non sunt in eo genere tantae commoditates corporis tamque productae temporibus tamque multae. Ratio ista, quam defendis, praecepta, quae didicisti, quae probas, funditus evertunt amicitiam, quamvis eam Epicurus, ut facit, in caelum efferat laudibus. Virtutis, magnitudinis animi, patientiae, fortitudinis fomentis dolor mitigari solet. Pungunt quasi aculeis interrogatiunculis angustis, quibus etiam qui assentiuntur nihil commutantur animo et idem abeunt, qui venerant. Nunc dicam de voluptate, nihil scilicet novi, ea tamen, quae te ipsum probaturum esse confidam. Quod autem principium officii quaerunt, melius quam Pyrrho; Cur igitur easdem res, inquam, Peripateticis dicentibus verbum nullum est, quod non intellegatur? Est enim tanti philosophi tamque nobilis audacter sua decreta defendere.&nbsp;<mark>Isto modo ne improbos quidem, si essent boni viri.</mark>&nbsp;Itaque contra est, ac dicitis; Vides igitur te aut ea sumere, quae non concedantur, aut ea, quae etiam concessa te nihil iuvent. Quae animi affectio suum cuique tribuens atque hanc, quam dico. Deinde, ubi erubuit-vis enim est permagna naturae-, confugit illuc, ut neget accedere quicquam posse ad voluptatem nihil dolentis. Ad eos igitur converte te, quaeso.</p>\r\n<ul>\r\n<li>In his igitur partibus duabus nihil erat, quod Zeno commutare gestiret.</li>\r\n<li>Isto modo ne improbos quidem, si essent boni viri.</li>\r\n<li>Ex rebus enim timiditas, non ex vocabulis nascitur.</li>\r\n<li>Quod quidem iam fit etiam in Academia.</li>\r\n<li>Sunt enim prima elementa naturae, quibus auctis v&iacute;rtutis quasi germen efficitur.</li>\r\n<li>Non quam nostram quidem, inquit Pomponius iocans;</li>\r\n</ul>\r\n<h2>Itaque vides, quo modo loquantur, nova verba fingunt, deserunt usitata.</h2>\r\n<p>Cum ageremus, inquit, vitae beatum et eundem supremum diem, scribebamus haec.&nbsp;<mark>Refert tamen, quo modo.</mark>&nbsp;Quid, si non modo utilitatem tibi nullam afferet, sed iacturae rei familiaris erunt faciendae, labores suscipiendi, adeundum vitae periculum? Si enim Zenoni licuit, cum rem aliquam invenisset inusitatam, inauditum quoque ei rei nomen inponere, cur non liceat Catoni? Illa enim, quae prosunt aut quae nocent, aut bona sunt aut mala, quae sint paria necesse est. Cum autem in quo sapienter dicimus, id a primo rectissime dicitur.</p>\r\n<dl>\r\n<dt><dfn>Istic sum, inquit.</dfn></dt>\r\n<dd>Ex quo, id quod omnes expetunt, beate vivendi ratio inveniri et comparari potest.</dd>\r\n<dt><dfn>A mene tu?</dfn></dt>\r\n<dd>Respondent extrema primis, media utrisque, omnia omnibus.</dd>\r\n<dt><dfn>In schola desinis.</dfn></dt>\r\n<dd>Non est ista, inquam, Piso, magna dissensio.</dd>\r\n<dt><dfn>Cur iustitia laudatur?</dfn></dt>\r\n<dd>Cum id fugiunt, re eadem defendunt, quae Peripatetici, verba.</dd>\r\n</dl>\r\n<ol>\r\n<li>Atqui haec patefactio quasi rerum opertarum, cum quid quidque sit aperitur, definitio est.</li>\r\n<li>Sed nimis multa.</li>\r\n<li>Hoc loco tenere se Triarius non potuit.</li>\r\n<li>Non enim quaero quid verum, sed quid cuique dicendum sit.</li>\r\n<li>Nam quibus rebus efficiuntur voluptates, eae non sunt in potestate sapientis.</li>\r\n<li>Nec vero alia sunt quaerenda contra Carneadeam illam sententiam.</li>\r\n</ol>\r\n<h3>Ille enim occurrentia nescio quae comminiscebatur;</h3>\r\n<p>Hoc autem tempore, etsi multa in omni parte Athenarum sunt in ipsis locis indicia summorum virorum, tamen ego illa moveor exhedra. Quamquam tu hanc copiosiorem etiam soles dicere. Ut enim consuetudo loquitur, id solum dicitur honestum, quod est populari fama gloriosum. Nam de isto magna dissensio est. Dicet pro me ipsa virtus nec dubitabit isti vestro beato M.</p>\r\n<p>Illa sunt similia: hebes acies est cuipiam oculorum, corpore alius senescit; In omni enim arte vel studio vel quavis scientia vel in ipsa virtute optimum quidque rarissimum est. Qui enim voluptatem ipsam contemnunt, iis licet dicere se acupenserem maenae non anteponere. Nunc haec primum fortasse audientis servire debemus.&nbsp;<strong>Ea possunt paria non esse.</strong>&nbsp;Ergo in iis adolescentibus bonam spem esse dicemus et magnam indolem, quos suis commodis inservituros et quicquid ipsis expediat facturos arbitrabimur? Qui haec didicerunt, quae ille contemnit, sic solent: Duo genera cupiditatum, naturales et inanes, naturalium duo, necessariae et non necessariae. Ergo et avarus erit, sed finite, et adulter, verum habebit modum, et luxuriosus eodem modo.</p>', '2022-10-11 14:30:00', NULL, b'1'),
(17, 'Ergo instituto veterum, quo etiam Stoici utuntur, hinc capiamus exordium.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Epicurus autem cum in prima commendatione voluptatem dixisset, si eam, quam Aristippus, idem tenere debuit ultimum bonorum, quod ille.', '<p>At enim, qua in vita est aliquid mali, ea beata esse non potest.&nbsp;<em>Duo Reges: constructio interrete.</em>&nbsp;Atque ut a corpore ordiar, videsne ut, si quae in membris prava aut debilitata aut inminuta sint, occultent homines? Quod autem in homine praestantissimum atque optimum est, id deseruit.&nbsp;<strong>Iubet igitur nos Pythius Apollo noscere nosmet ipsos.</strong>&nbsp;Sed eum qui audiebant, quoad poterant, defendebant sententiam suam. Maximeque eos videre possumus res gestas audire et legere velle, qui a spe gerendi absunt confecti senectute.</p>\r\n<p>Inde sermone vario&nbsp;<em>[redacted]</em>&nbsp;illa a Dipylo stadia confecimus.&nbsp;<em>At multis malis affectus.</em>&nbsp;Qua exposita scire cupio quae causa sit, cur Zeno ab hac antiqua constitutione desciverit, quidnam horum ab eo non sit probatum;&nbsp;<strong>Deprehensus omnem poenam contemnet.</strong>&nbsp;<strong>Hunc vos beatum;</strong>&nbsp;Ita, quem ad modum in senatu semper est aliquis, qui interpretem postulet, sic, isti nobis cum interprete audiendi sunt. Hunc igitur finem illi tenuerunt, quodque ego pluribus verbis, illi brevius secundum naturam vivere, hoc iis bonorum videbatur extremum. Quid est, quod ab ea absolvi et perfici debeat?</p>\r\n<ol>\r\n<li>Ita similis erit ei finis boni, atque antea fuerat, neque idem tamen;</li>\r\n<li>Quis non odit sordidos, vanos, leves, futtiles?</li>\r\n<li>Ut proverbia non nulla veriora sint quam vestra dogmata.</li>\r\n<li>Animadverti, &iacute;nquam, te isto modo paulo ante ponere, et scio ab Antiocho nostro dici sic solere;</li>\r\n</ol>\r\n<p>Si est nihil nisi corpus, summa erunt illa: valitudo, vacuitas doloris, pulchritudo, cetera. Tubulum fuisse, qua illum, cuius is condemnatus est rogatione, P. Non igitur bene. Est autem situm in nobis ut et adversa quasi perpetua oblivione obruamus et secunda iucunde ac suaviter meminerimus. Illa enim, quae prosunt aut quae nocent, aut bona sunt aut mala, quae sint paria necesse est.&nbsp;<strong>Vide, quantum, inquam, fallare, Torquate.</strong>&nbsp;Ipse negat, ut ante dixi, luxuriosorum vitam reprehendendam, nisi plane fatui sint, id est nisi aut cupiant aut metuant.&nbsp;<strong>Praeclare hoc quidem.</strong>&nbsp;Quid, de quo nulla dissensio est? Vos autem cum perspicuis dubia debeatis illustrare, dubiis perspicua conamini tollere. Id et fieri posse et saepe esse factum et ad voluptates percipiendas maxime pertinere. Quid est igitur, cur ita semper deum appellet Epicurus beatum et aeternum?</p>\r\n<ul>\r\n<li>Roges enim Aristonem, bonane ei videantur haec: vacuitas doloris, divitiae, valitudo;</li>\r\n<li>Facete M.</li>\r\n<li>Satisne vobis videor pro meo iure in vestris auribus commentatus?</li>\r\n<li>A villa enim, credo, et: Si ibi te esse scissem, ad te ipse venissem.</li>\r\n</ul>\r\n<dl>\r\n<dt><dfn>Poterat autem inpune;</dfn></dt>\r\n<dd>Et si turpitudinem fugimus in statu et motu corporis, quid est cur pulchritudinem non sequamur?</dd>\r\n<dt><dfn>Quibusnam praeteritis?</dfn></dt>\r\n<dd>Age sane, inquam.</dd>\r\n<dt><dfn>Istic sum, inquit.</dfn></dt>\r\n<dd>Sed finge non solum callidum eum, qui aliquid improbe faciat, verum etiam praepotentem, ut M.</dd>\r\n<dt><dfn>Itaque fecimus.</dfn></dt>\r\n<dd>At cum de plurimis eadem dicit, tum certe de maximis.</dd>\r\n</dl>\r\n<p>Idemne potest esse dies saepius, qui semel fuit? Ut scias me intellegere, primum idem esse dico voluptatem, quod ille don. Quid autem est amare, e quo nomen ductum amicitiae est, nisi velle bonis aliquem affici quam maximis, etiamsi ad se ex iis nihil redundet? Inquit, respondet: Quia, nisi quod honestum est, nullum est aliud bonum! Non quaero iam verumne sit; Octavium, Marci filium, familiarem meum, confici vidi, nec vero semel nec ad breve tempus, sed et saepe et plane diu. Verum esto: verbum ipsum voluptatis non habet dignitatem, nec nos fortasse intellegimus. Restincta enim sitis stabilitatem voluptatis habet, inquit, illa autem voluptas ipsius restinctionis in motu est. Nihilne te delectat umquam -video, quicum loquar-, te igitur, Torquate, ipsum per se nihil delectat? Est tamen ea secundum naturam multoque nos ad se expetendam magis hortatur quam superiora omnia. At vero Epicurus una in domo, et ea quidem angusta, quam magnos quantaque amoris conspiratione consentientis tenuit amicorum greges! quod fit etiam nunc ab Epicureis. Qua tu etiam inprudens utebare non numquam. Stoici restant, ei quidem non unam aliquam aut alteram rem a nobis, sed totam ad se nostram philosophiam transtulerunt; Quid ergo aliud intellegetur nisi uti ne quae pars naturae neglegatur? Bonum appello quicquid secundurn naturam est, quod contra malum, nec ego solus, sed tu etiam, Chrysippe, in foro, domi;</p>\r\n<p>Nam si beatus umquam fuisset, beatam vitam usque ad illum a Cyro extructum rogum pertulisset.&nbsp;<strong>Quam illa ardentis amores excitaret sui! Cur tandem?</strong>&nbsp;Sed finge non solum callidum eum, qui aliquid improbe faciat, verum etiam praepotentem, ut M. Sic enim maiores nostri labores non fugiendos tristissimo tamen verbo aerumnas etiam in deo nominaverunt.&nbsp;<mark>Maximus dolor, inquit, brevis est.</mark>&nbsp;Stoici restant, ei quidem non unam aliquam aut alteram rem a nobis, sed totam ad se nostram philosophiam transtulerunt; Non enim, si omnia non sequebatur, idcirco non erat ortus illinc.</p>', '2022-10-05 09:19:00', NULL, b'1'),
(18, 'Quis est tam dissimile homini.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quae cum magnifice primo dici viderentur, considerata minus probabantur. Sed quia studebat laudi et dignitati, multum in virtute processerat.', '<p>Duo Reges: constructio interrete. Iam illud quale tandem est, bona praeterita non effluere sapienti, mala meminisse non oportere?&nbsp;<em>Pollicetur certe.</em>&nbsp;<mark>Verum hoc idem saepe faciamus.</mark>&nbsp;Etenim semper illud extra est, quod arte comprehenditur. Ut scias me intellegere, primum idem esse dico voluptatem, quod ille don.</p>\r\n<p>Duo enim genera quae erant, fecit tria. Inquit, respondet: Quia, nisi quod honestum est, nullum est aliud bonum! Non quaero iam verumne sit; At quicum ioca seria, ut dicitur, quicum arcana, quicum occulta omnia? An me, inquam, nisi te audire vellem, censes haec dicturum fuisse? Cum autem in quo sapienter dicimus, id a primo rectissime dicitur.&nbsp;<em>At iste non dolendi status non vocatur voluptas.</em></p>\r\n<dl>\r\n<dt><dfn>Scaevolam M.</dfn></dt>\r\n<dd>Obsecro, inquit, Torquate, haec dicit Epicurus?</dd>\r\n<dt><dfn>Erat enim Polemonis.</dfn></dt>\r\n<dd>Negat esse eam, inquit, propter se expetendam.</dd>\r\n<dt><dfn>Quare conare, quaeso.</dfn></dt>\r\n<dd>Commoda autem et incommoda in eo genere sunt, quae praeposita et reiecta diximus;</dd>\r\n</dl>\r\n<p>Progredientibus autem aetatibus sensim tardeve potius quasi nosmet ipsos cognoscimus. Illa sunt similia: hebes acies est cuipiam oculorum, corpore alius senescit; At quanta conantur! Mundum hunc omnem oppidum esse nostrum! Incendi igitur eos, qui audiunt, vides.&nbsp;<strong>Sed fortuna fortis;</strong>&nbsp;Quod autem magnum dolorem brevem, longinquum levem esse dicitis, id non intellego quale sit. Habes undique expletam et perfectam, Torquate, formam honestatis, quae tota quattuor his virtutibus, quae a te quoque commemoratae sunt, continetur. Voluptatem cum summum bonum diceret, primum in eo ipso parum vidit, deinde hoc quoque alienum; Velut ego nunc moveor.</p>\r\n<ol>\r\n<li>His similes sunt omnes, qui virtuti student levantur vitiis, levantur erroribus, nisi forte censes Ti.</li>\r\n<li>Non est ista, inquam, Piso, magna dissensio.</li>\r\n<li>Nec hoc ille non vidit, sed verborum magnificentia est et gloria delectatus.</li>\r\n</ol>\r\n<ul>\r\n<li>Diodorus, eius auditor, adiungit ad honestatem vacuitatem doloris.</li>\r\n<li>Est autem etiam actio quaedam corporis, quae motus et status naturae congruentis tenet;</li>\r\n</ul>\r\n<p>Tum Lucius: Mihi vero ista valde probata sunt, quod item fratri puto. Aut unde est hoc contritum vetustate proverbium: quicum in tenebris? Dic in quovis conventu te omnia facere, ne doleas. At multis se probavit. Gracchum patrem non beatiorem fuisse quam fillum, cum alter stabilire rem publicam studuerit, alter evertere. Si enim non fuit eorum iudicii, nihilo magis hoc non addito illud est iudicatum-. Non enim quaero quid verum, sed quid cuique dicendum sit.&nbsp;<strong>Sed ego in hoc resisto;</strong></p>\r\n<h2>Negare non possum.</h2>\r\n<p>Uterque enim summo bono fruitur, id est voluptate. Quod enim vituperabile est per se ipsum, id eo ipso vitium nominatum puto, vel etiam a vitio dictum vituperari. Tecum optime, deinde etiam cum mediocri amico. Quem si tenueris, non modo meum Ciceronem, sed etiam me ipsum abducas licebit. Quare istam quoque aggredere tractatam praesertim et ab aliis et a te ipso saepe, ut tibi deesse non possit oratio. Illa sunt similia: hebes acies est cuipiam oculorum, corpore alius senescit;</p>', '2022-10-12 13:38:00', NULL, b'1'),
(19, 'Teneo, inquit, finem illi videri nihil dolere.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Restinguet citius, si ardentem acceperit. Sed fac ista esse non inportuna; Atqui pugnantibus et contrariis studiis consiliisque semper utens nihil quieti videre, nihil tranquilli potest.', '<p><em>Murenam te accusante defenderem.</em>&nbsp;Si enim ita est, vide ne facinus facias, cum mori suadeas. Duo Reges: constructio interrete. Audio equidem philosophi vocem, Epicure, sed quid tibi dicendum sit oblitus es. Ita fit cum gravior, tum etiam splendidior oratio. Suam denique cuique naturam esse ad vivendum ducem. Primum in nostrane potestate est, quid meminerimus?</p>\n<p>Nulla profecto est, quin suam vim retineat a primo ad extremum. Itaque quantum adiit periculum! ad honestatem enim illum omnem conatum suum referebat, non ad voluptatem. Ut in voluptate sit, qui epuletur, in dolore, qui torqueatur. Ut Phidias potest a primo instituere signum idque perficere, potest ab alio inchoatum accipere et absolvere, huic est sapientia similis;</p>\n<dl>\n<dt><dfn>Praeteritis, inquit, gaudeo.</dfn></dt>\n<dd>Quos quidem dies quem ad modum agatis et in quantam hominum facetorum urbanitatem incurratis, non diconihil opus est litibus-;</dd>\n<dt><dfn>Nos vero, inquit ille;</dfn></dt>\n<dd>Sed mehercule pergrata mihi oratio tua.</dd>\n<dt><dfn>Etiam beatissimum?</dfn></dt>\n<dd>Quacumque enim ingredimur, in aliqua historia vestigium ponimus.</dd>\n<dt><dfn>Sed videbimus.</dfn></dt>\n<dd>Vos autem cum perspicuis dubia debeatis illustrare, dubiis perspicua conamini tollere.</dd>\n<dt><dfn>Ut pulsi recurrant?</dfn></dt>\n<dd>Facillimum id quidem est, inquam.</dd>\n<dt><dfn>Est, ut dicis, inquit;</dfn></dt>\n<dd>Suo genere perveniant ad extremum;</dd>\n</dl>\n<ol>\n<li>Si alia sentit, inquam, alia loquitur, numquam intellegam quid sentiat;</li>\n<li>Si longus, levis dictata sunt.</li>\n<li>In qua si nihil est praeter rationem, sit in una virtute finis bonorum;</li>\n<li>Aliena dixit in physicis nec ea ipsa, quae tibi probarentur;</li>\n</ol>\n<p>Etenim nec iustitia nec amicitia esse omnino poterunt, nisi ipsae per se expetuntur.&nbsp;<em>Aliter enim explicari, quod quaeritur, non potest.</em>&nbsp;Itaque et manendi in vita et migrandi ratio omnis iis rebus, quas supra dixi, metienda. Sin eam, quam Hieronymus, ne fecisset idem, ut voluptatem illam Aristippi in prima commendatione poneret.&nbsp;<em>Dicimus aliquem hilare vivere;</em>&nbsp;Neque solum ea communia, verum etiam paria esse dixerunt. Sin eam, quam Hieronymus, ne fecisset idem, ut voluptatem illam Aristippi in prima commendatione poneret. Ex quo illud efficitur, qui bene cenent omnis libenter cenare, qui libenter, non continuo bene.</p>\n<h3>Nihil opus est exemplis hoc facere longius.</h3>\n<p>Atque ab isto capite fluere necesse est omnem rationem bonorum et malorum. In voluptate corporis-addam, si vis, animi, dum ea ipsa, ut vultis, sit e corpore-situm est vivere beate. Atqui haec patefactio quasi rerum opertarum, cum quid quidque sit aperitur, definitio est.&nbsp;<mark>Summae mihi videtur inscitiae.</mark>&nbsp;Itaque ne iustitiam quidem recte quis dixerit per se ipsam optabilem, sed quia iucunditatis vel plurimum afferat. Ait enim se, si uratur, Quam hoc suave! dicturum. Quid est igitur, cur ita semper deum appellet Epicurus beatum et aeternum?&nbsp;<mark>Haec para/doca illi, nos admirabilia dicamus.</mark>&nbsp;Studet enim meus is audire Cicero quaenam sit istius veteris, quam commemoras, Academiae de finibus bonorum Peripateticorumque sententia. Nec vero umquam summum bonum assequi quisquam posset, si omnia illa, quae sunt extra, quamquam expetenda, summo bono continerentur.&nbsp;<em>Haec para/doca illi, nos admirabilia dicamus.</em>&nbsp;Idemque diviserunt naturam hominis in animum et corpus. Hoc ne statuam quidem dicturam pater aiebat, si loqui posset.</p>\n<ul>\n<li>Unum nescio, quo modo possit, si luxuriosus sit, finitas cupiditates habere.</li>\n<li>Gerendus est mos, modo recte sentiat.</li>\n<li>Haec qui audierit, ut ridere non curet, discedet tamen nihilo firmior ad dolorem ferendum, quam venerat.</li>\n</ul>\n<h2>Ut scias me intellegere, primum idem esse dico voluptatem, quod ille don.</h2>\n<p>Ac tamen, ne cui loco non videatur esse responsum, pauca etiam nunc dicam ad reliquam orationem tuam. Atqui, inquit, si Stoicis concedis ut virtus sola, si adsit vitam efficiat beatam, concedis etiam Peripateticis. Alterum significari idem, ut si diceretur, officia media omnia aut pleraque servantem vivere. Quis autem honesta in familia institutus et educatus ingenue non ipsa turpitudine, etiamsi eum laesura non sit, offenditur? Quid est, quod ab ea absolvi et perfici debeat? Utrum igitur percurri omnem Epicuri disciplinam placet an de una voluptate quaeri, de qua omne certamen est? Zeno autem, quod suam, quod propriam speciem habeat, cur appetendum sit, id solum bonum appellat, beatam autem vitam eam solam, quae cum virtute degatur.&nbsp;<strong>Nihil ad rem! Ne sit sane;</strong>&nbsp;Nam de isto magna dissensio est.&nbsp;<em>Sequitur disserendi ratio cognitioque naturae;</em>&nbsp;<mark>Gloriosa ostentatio in constituendo summo bono.</mark>&nbsp;Quae qui non vident, nihil umquam magnum ac cognitione dignum amaverunt.</p>', '2022-10-13 21:44:00', '2022-10-22 15:03:49', b'1');

-- --------------------------------------------------------

--
-- Table structure for table `TbArticleSources`
--

CREATE TABLE `TbArticleSources` (
  `Id` int(11) NOT NULL,
  `IdArticle` int(11) NOT NULL,
  `IdSource` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `TbAuthors`
--

CREATE TABLE `TbAuthors` (
  `Id` int(11) NOT NULL,
  `About` text DEFAULT NULL,
  `Role` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `TbAuthors`
--

INSERT INTO `TbAuthors` (`Id`, `About`, `Role`) VALUES
(3, NULL, NULL),
(9, NULL, NULL),
(10, 'Enhanced 24 hour focus group', 'Editor'),
(30, NULL, NULL),
(48, NULL, NULL),
(57, 'Ergonomic upward-trending paradigm', 'Reporter'),
(60, 'Proactive needs-based utilisation', 'Writer'),
(76, 'Digitized context-sensitive hardware', 'Editor'),
(77, NULL, NULL),
(83, NULL, NULL),
(91, 'Optional regional local area network', 'Reporter'),
(101, 'Ameliorated value-added strategy', 'Commentator'),
(112, 'Re-contextualized tertiary customer loyalty', 'Editor');

-- --------------------------------------------------------

--
-- Table structure for table `TbAuthorSocials`
--

CREATE TABLE `TbAuthorSocials` (
  `Id` int(11) NOT NULL,
  `IdAuthor` int(11) NOT NULL,
  `Social` text NOT NULL,
  `URL` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `TbAuthorSocials`
--

INSERT INTO `TbAuthorSocials` (`Id`, `IdAuthor`, `Social`, `URL`) VALUES
(15, 10, 'Personal site', 'https://example.com'),
(16, 76, 'Personal site', 'https://example.com'),
(17, 112, 'Personal site', 'https://example.com'),
(18, 101, 'Personal site', 'https://example.com');

-- --------------------------------------------------------

--
-- Table structure for table `TbCategories`
--

CREATE TABLE `TbCategories` (
  `Id` int(11) NOT NULL,
  `IdCategory` int(11) DEFAULT NULL,
  `Name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `TbCategories`
--

INSERT INTO `TbCategories` (`Id`, `IdCategory`, `Name`) VALUES
(1, 1, 'World'),
(2, 2, 'Local'),
(3, 3, 'Sport'),
(4, 4, 'Business'),
(5, 4, 'Finance'),
(6, 4, 'Real Estate'),
(7, 2, 'Politics'),
(8, 1, 'Climate'),
(9, 2, 'Transport');

-- --------------------------------------------------------

--
-- Table structure for table `TbComments`
--

CREATE TABLE `TbComments` (
  `Id` int(11) NOT NULL,
  `IdComment` int(11) DEFAULT NULL,
  `IdArticle` int(11) NOT NULL,
  `IdUser` int(11) NOT NULL,
  `Content` text NOT NULL,
  `PublishedDate` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `TbComments`
--

INSERT INTO `TbComments` (`Id`, `IdComment`, `IdArticle`, `IdUser`, `Content`, `PublishedDate`) VALUES
(1, NULL, 15, 14, 'Test Comment', '2022-11-15 16:33:50'),
(2, NULL, 15, 14, 'Test Comment2', '2022-11-15 16:33:50'),
(3, 2, 15, 14, 'SubComment', '2022-11-15 16:33:50'),
(4, 3, 15, 14, 'DoubleSubComment', '2022-11-15 16:33:50');

-- --------------------------------------------------------

--
-- Table structure for table `TbNotifications`
--

CREATE TABLE `TbNotifications` (
  `Id` int(11) NOT NULL,
  `IdUser` int(11) NOT NULL,
  `Notification` text NOT NULL,
  `NotifyDate` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `TbPhotos`
--

CREATE TABLE `TbPhotos` (
  `Id` int(11) NOT NULL,
  `IdArticle` int(11) NOT NULL,
  `Photo` text NOT NULL,
  `Title` text NOT NULL,
  `Source` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `TbPhotos`
--

INSERT INTO `TbPhotos` (`Id`, `IdArticle`, `Photo`, `Title`, `Source`) VALUES
(5, 16, 'https://images.unsplash.com/photo-1666571190601-5be980f58d24?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxleHBsb3JlLWZlZWR8OHx8fGVufDB8fHx8&auto=format&fit=crop&w=500&q=60', 'Unsplash', 'unsplash.com'),
(6, 15, 'https://images.unsplash.com/photo-1666521806890-2216eaa46a71?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxleHBsb3JlLWZlZWR8NXx8fGVufDB8fHx8&auto=format&fit=crop&w=500&q=60', 'Unsplash', 'unsplash.com'),
(7, 16, 'https://images.unsplash.com/photo-1666598697726-1b2e572cb56e?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxleHBsb3JlLWZlZWR8Mnx8fGVufDB8fHx8&auto=format&fit=crop&w=500&q=60', 'Unsplash', 'unsplash.com'),
(8, 18, 'https://images.unsplash.com/photo-1666545459280-511796ce1d2f?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxleHBsb3JlLWZlZWR8NHx8fGVufDB8fHx8&auto=format&fit=crop&w=500&q=60', 'Unsplash', 'unsplash.com'),
(9, 19, 'https://images.unsplash.com/photo-1666529891673-e0fd35bdbd3e?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxleHBsb3JlLWZlZWR8MXx8fGVufDB8fHx8&auto=format&fit=crop&w=500&q=60', 'Unsplash', 'unsplash.com'),
(10, 15, 'https://images.unsplash.com/photo-1666521826419-580022ef150e?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxleHBsb3JlLWZlZWR8MTV8fHxlbnwwfHx8fA%3D%3D&auto=format&fit=crop&w=500&q=60', 'Unsplash', 'unsplash.com');

-- --------------------------------------------------------

--
-- Table structure for table `TbReactions`
--

CREATE TABLE `TbReactions` (
  `Id` int(11) NOT NULL,
  `IdComment` int(11) NOT NULL,
  `IdUser` int(11) NOT NULL,
  `Reaction` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `TbReactions`
--

INSERT INTO `TbReactions` (`Id`, `IdComment`, `IdUser`, `Reaction`) VALUES
(3, 2, 10, 1),
(58, 2, 9, 1),
(60, 7, 9, 1);

-- --------------------------------------------------------

--
-- Table structure for table `TbSources`
--

CREATE TABLE `TbSources` (
  `Id` int(11) NOT NULL,
  `Source` text NOT NULL,
  `URL` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `TbUserFollows`
--

CREATE TABLE `TbUserFollows` (
  `Id` int(11) NOT NULL,
  `Follower` int(11) NOT NULL,
  `Followed` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `TbUsers`
--

CREATE TABLE `TbUsers` (
  `Id` int(11) NOT NULL,
  `Email` text NOT NULL,
  `Name` text DEFAULT NULL,
  `Surname` text DEFAULT NULL,
  `Password` text NOT NULL,
  `Photo` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `TbUsers`
--

INSERT INTO `TbUsers` (`Id`, `Email`, `Name`, `Surname`, `Password`, `Photo`) VALUES
(1, 'admin@admin.com', 'Admin', 'Admin', '$2y$10$EpgE.j1DA17chnnlK.gJqO9dK8.b.I6tD7Zq/YWXI9QGSMs0uCqJK', NULL),
(3, 'jennyziva@mail.com', 'Jenny', 'Ziva', '$2y$10$xfp98gf8FWokSx/OasvR.OCHKnQa6YLNKjMs4m6RhnHQ8.qUjJNdO', NULL),
(9, 'davidhaze@mail.com', 'David', 'Haze', '$2y$10$dbqem/Ii2q0gJvhwD4kng.w.04w/JULZfupnilmWNfvRZQiIX0a4q', NULL),
(10, 'henryport@mail.com', 'Henry', 'Port', '$2y$10$NSwZXGCyyMvstYzxuVBZcevn//ySbuh4BWzueK0BPg0mvASulR.Sm', NULL),
(14, 'dgawkes0@google.es', 'Daveta', 'Gawkes', '$2y$10$dbqem/Ii2q0gJvhwD4kng.w.04w/JULZfupnilmWNfvRZQiIX0a4q', 'e.png'),
(15, 'srodolf1@who.int', 'Suzette', 'Rodolf', '$2y$10$dbqem/Ii2q0gJvhwD4kng.w.04w/JULZfupnilmWNfvRZQiIX0a4q', NULL),
(16, 'ecompston2@google.fr', 'Elana', 'Compston', '$2y$10$dbqem/Ii2q0gJvhwD4kng.w.04w/JULZfupnilmWNfvRZQiIX0a4q', 'e.png'),
(17, 'kwillan3@ted.com', 'Kirsten', 'Willan', '$2y$10$dbqem/Ii2q0gJvhwD4kng.w.04w/JULZfupnilmWNfvRZQiIX0a4q', NULL),
(18, 'hswayland4@cloudflare.com', 'Henryetta', 'Swayland', '$2y$10$dbqem/Ii2q0gJvhwD4kng.w.04w/JULZfupnilmWNfvRZQiIX0a4q', NULL),
(19, 'emulles5@cbsnews.com', 'Ed', 'Mulles', '$2y$10$dbqem/Ii2q0gJvhwD4kng.w.04w/JULZfupnilmWNfvRZQiIX0a4q', NULL),
(20, 'cpymar6@smugmug.com', 'Cristi', 'Pymar', '$2y$10$dbqem/Ii2q0gJvhwD4kng.w.04w/JULZfupnilmWNfvRZQiIX0a4q', 'a.png'),
(21, 'apetford7@businessweek.com', 'Alvina', 'Petford', '$2y$10$dbqem/Ii2q0gJvhwD4kng.w.04w/JULZfupnilmWNfvRZQiIX0a4q', NULL),
(22, 'hrodriguez8@zdnet.com', 'Hammad', 'Rodriguez', '$2y$10$dbqem/Ii2q0gJvhwD4kng.w.04w/JULZfupnilmWNfvRZQiIX0a4q', NULL),
(23, 'ebarrett9@example.com', 'Eustace', 'Barrett', '$2y$10$dbqem/Ii2q0gJvhwD4kng.w.04w/JULZfupnilmWNfvRZQiIX0a4q', 'd.png'),
(24, 'rvaladeza@hibu.com', 'Roselle', 'Valadez', '$2y$10$dbqem/Ii2q0gJvhwD4kng.w.04w/JULZfupnilmWNfvRZQiIX0a4q', 'e.png'),
(25, 'tcloutb@patch.com', 'Tomas', 'Clout', '$2y$10$dbqem/Ii2q0gJvhwD4kng.w.04w/JULZfupnilmWNfvRZQiIX0a4q', NULL),
(26, 'cmaccurtainc@alexa.com', 'Cortie', 'MacCurtain', '$2y$10$dbqem/Ii2q0gJvhwD4kng.w.04w/JULZfupnilmWNfvRZQiIX0a4q', NULL),
(27, 'tmackellerd@mapy.cz', 'Torre', 'MacKeller', '$2y$10$dbqem/Ii2q0gJvhwD4kng.w.04w/JULZfupnilmWNfvRZQiIX0a4q', 'c.png'),
(28, 'nottleye@berkeley.edu', 'Noel', 'Ottley', '$2y$10$dbqem/Ii2q0gJvhwD4kng.w.04w/JULZfupnilmWNfvRZQiIX0a4q', NULL),
(29, 'sfellowsf@gov.uk', 'Stanwood', 'Fellows', '$2y$10$dbqem/Ii2q0gJvhwD4kng.w.04w/JULZfupnilmWNfvRZQiIX0a4q', 'b.png'),
(30, 'jdunrigeg@nifty.com', 'Justin', 'Dunrige', '$2y$10$dbqem/Ii2q0gJvhwD4kng.w.04w/JULZfupnilmWNfvRZQiIX0a4q', NULL),
(31, 'cdaulbyh@tiny.cc', 'Chariot', 'D\'Aulby', '$2y$10$dbqem/Ii2q0gJvhwD4kng.w.04w/JULZfupnilmWNfvRZQiIX0a4q', NULL),
(32, 'oagostinii@trellian.com', 'Orelia', 'Agostini', '$2y$10$dbqem/Ii2q0gJvhwD4kng.w.04w/JULZfupnilmWNfvRZQiIX0a4q', NULL),
(33, 'rprierj@oakley.com', 'Raffarty', 'Prier', '$2y$10$dbqem/Ii2q0gJvhwD4kng.w.04w/JULZfupnilmWNfvRZQiIX0a4q', NULL),
(34, 'abittertonk@liveinternet.ru', 'Ava', 'Bitterton', '$2y$10$dbqem/Ii2q0gJvhwD4kng.w.04w/JULZfupnilmWNfvRZQiIX0a4q', NULL),
(35, 'ngossartl@ucla.edu', 'Nessa', 'Gossart', '$2y$10$dbqem/Ii2q0gJvhwD4kng.w.04w/JULZfupnilmWNfvRZQiIX0a4q', 'a.png'),
(36, 'aburghm@nature.com', 'Alyssa', 'Burgh', '$2y$10$dbqem/Ii2q0gJvhwD4kng.w.04w/JULZfupnilmWNfvRZQiIX0a4q', 'c.png'),
(37, 'hbuckettn@360.cn', 'Horten', 'Buckett', '$2y$10$dbqem/Ii2q0gJvhwD4kng.w.04w/JULZfupnilmWNfvRZQiIX0a4q', NULL),
(38, 'averyano@house.gov', 'Ada', 'Veryan', '$2y$10$dbqem/Ii2q0gJvhwD4kng.w.04w/JULZfupnilmWNfvRZQiIX0a4q', 'a.png'),
(39, 'dguitelp@ezinearticles.com', 'Dorita', 'Guitel', '$2y$10$dbqem/Ii2q0gJvhwD4kng.w.04w/JULZfupnilmWNfvRZQiIX0a4q', NULL),
(40, 'kdonaghieq@usda.gov', 'Kendrick', 'Donaghie', '$2y$10$dbqem/Ii2q0gJvhwD4kng.w.04w/JULZfupnilmWNfvRZQiIX0a4q', 'a.png'),
(41, 'mbarnbyr@soup.io', 'Madalena', 'Barnby', '$2y$10$dbqem/Ii2q0gJvhwD4kng.w.04w/JULZfupnilmWNfvRZQiIX0a4q', 'b.png'),
(42, 'wtreess@fotki.com', 'Winfred', 'Trees', '$2y$10$dbqem/Ii2q0gJvhwD4kng.w.04w/JULZfupnilmWNfvRZQiIX0a4q', NULL),
(43, 'ssibbett@ft.com', 'Salem', 'Sibbet', '$2y$10$dbqem/Ii2q0gJvhwD4kng.w.04w/JULZfupnilmWNfvRZQiIX0a4q', NULL),
(44, 'cvendittiu@blogger.com', 'Cherish', 'Venditti', '$2y$10$dbqem/Ii2q0gJvhwD4kng.w.04w/JULZfupnilmWNfvRZQiIX0a4q', NULL),
(45, 'belderedv@geocities.com', 'Betty', 'Eldered', '$2y$10$dbqem/Ii2q0gJvhwD4kng.w.04w/JULZfupnilmWNfvRZQiIX0a4q', NULL),
(46, 'bparisow@rambler.ru', 'Brendis', 'Pariso', '$2y$10$dbqem/Ii2q0gJvhwD4kng.w.04w/JULZfupnilmWNfvRZQiIX0a4q', 'c.png'),
(47, 'cscottix@newsvine.com', 'Chas', 'Scotti', '$2y$10$dbqem/Ii2q0gJvhwD4kng.w.04w/JULZfupnilmWNfvRZQiIX0a4q', NULL),
(48, 'wnutty@histats.com', 'Wilek', 'Nutt', '$2y$10$dbqem/Ii2q0gJvhwD4kng.w.04w/JULZfupnilmWNfvRZQiIX0a4q', NULL),
(49, 'breadettz@hc360.com', 'Benedicta', 'Readett', '$2y$10$dbqem/Ii2q0gJvhwD4kng.w.04w/JULZfupnilmWNfvRZQiIX0a4q', 'a.png'),
(50, 'wmapledoore10@blogspot.com', 'Willamina', 'Mapledoore', '$2y$10$dbqem/Ii2q0gJvhwD4kng.w.04w/JULZfupnilmWNfvRZQiIX0a4q', NULL),
(51, 'dedgehill11@google.es', 'Dal', 'Edgehill', '$2y$10$dbqem/Ii2q0gJvhwD4kng.w.04w/JULZfupnilmWNfvRZQiIX0a4q', NULL),
(52, 'lraysdale12@mashable.com', 'Leif', 'Raysdale', '$2y$10$dbqem/Ii2q0gJvhwD4kng.w.04w/JULZfupnilmWNfvRZQiIX0a4q', 'd.png'),
(53, 'tsmerdon13@hexun.com', 'Tina', 'Smerdon', '$2y$10$dbqem/Ii2q0gJvhwD4kng.w.04w/JULZfupnilmWNfvRZQiIX0a4q', 'd.png'),
(54, 'athirsk14@vk.com', 'Aurea', 'Thirsk', '$2y$10$dbqem/Ii2q0gJvhwD4kng.w.04w/JULZfupnilmWNfvRZQiIX0a4q', 'd.png'),
(55, 'lsnibson15@google.com.br', 'Linoel', 'Snibson', '$2y$10$dbqem/Ii2q0gJvhwD4kng.w.04w/JULZfupnilmWNfvRZQiIX0a4q', 'b.png'),
(56, 'rplimmer16@360.cn', 'Renata', 'Plimmer', '$2y$10$dbqem/Ii2q0gJvhwD4kng.w.04w/JULZfupnilmWNfvRZQiIX0a4q', NULL),
(57, 'jpidcock17@qq.com', 'Janice', 'Pidcock', '$2y$10$dbqem/Ii2q0gJvhwD4kng.w.04w/JULZfupnilmWNfvRZQiIX0a4q', NULL),
(58, 'bmillson18@indiegogo.com', 'Blondy', 'Millson', '$2y$10$dbqem/Ii2q0gJvhwD4kng.w.04w/JULZfupnilmWNfvRZQiIX0a4q', 'c.png'),
(59, 'hdecruce19@blogtalkradio.com', 'Helen', 'De Cruce', '$2y$10$dbqem/Ii2q0gJvhwD4kng.w.04w/JULZfupnilmWNfvRZQiIX0a4q', NULL),
(60, 'dpalphramand1a@nature.com', 'Douglas', 'Palphramand', '$2y$10$dbqem/Ii2q0gJvhwD4kng.w.04w/JULZfupnilmWNfvRZQiIX0a4q', NULL),
(61, 'nrackham1b@cyberchimps.com', 'Nicolette', 'Rackham', '$2y$10$dbqem/Ii2q0gJvhwD4kng.w.04w/JULZfupnilmWNfvRZQiIX0a4q', NULL),
(62, 'ctunnicliff1c@apple.com', 'Constantine', 'Tunnicliff', '$2y$10$dbqem/Ii2q0gJvhwD4kng.w.04w/JULZfupnilmWNfvRZQiIX0a4q', NULL),
(63, 'bdartan1d@nytimes.com', 'Babb', 'Dartan', '$2y$10$dbqem/Ii2q0gJvhwD4kng.w.04w/JULZfupnilmWNfvRZQiIX0a4q', 'e.png'),
(64, 'ppigram1e@dot.gov', 'Petronilla', 'Pigram', '$2y$10$dbqem/Ii2q0gJvhwD4kng.w.04w/JULZfupnilmWNfvRZQiIX0a4q', 'e.png'),
(65, 'latwater1f@indiatimes.com', 'Linc', 'Atwater', '$2y$10$dbqem/Ii2q0gJvhwD4kng.w.04w/JULZfupnilmWNfvRZQiIX0a4q', 'b.png'),
(66, 'lsackey1g@sfgate.com', 'Locke', 'Sackey', '$2y$10$dbqem/Ii2q0gJvhwD4kng.w.04w/JULZfupnilmWNfvRZQiIX0a4q', NULL),
(67, 'pleicester1h@mayoclinic.com', 'Pedro', 'Leicester', '$2y$10$dbqem/Ii2q0gJvhwD4kng.w.04w/JULZfupnilmWNfvRZQiIX0a4q', 'a.png'),
(68, 'dalfwy1i@lulu.com', 'Devonna', 'Alfwy', '$2y$10$dbqem/Ii2q0gJvhwD4kng.w.04w/JULZfupnilmWNfvRZQiIX0a4q', 'a.png'),
(69, 'rfeatherby1j@columbia.edu', 'Rubina', 'Featherby', '$2y$10$dbqem/Ii2q0gJvhwD4kng.w.04w/JULZfupnilmWNfvRZQiIX0a4q', 'c.png'),
(70, 'rvenner1k@thetimes.co.uk', 'Randi', 'Venner', '$2y$10$dbqem/Ii2q0gJvhwD4kng.w.04w/JULZfupnilmWNfvRZQiIX0a4q', NULL),
(71, 'kironside1l@archive.org', 'Kayley', 'Ironside', '$2y$10$dbqem/Ii2q0gJvhwD4kng.w.04w/JULZfupnilmWNfvRZQiIX0a4q', NULL),
(72, 'kpetru1m@nps.gov', 'Karisa', 'Petru', '$2y$10$dbqem/Ii2q0gJvhwD4kng.w.04w/JULZfupnilmWNfvRZQiIX0a4q', 'a.png'),
(73, 'hfancott1n@sakura.ne.jp', 'Herculie', 'Fancott', '$2y$10$dbqem/Ii2q0gJvhwD4kng.w.04w/JULZfupnilmWNfvRZQiIX0a4q', 'b.png'),
(74, 'kpassler1o@g.co', 'Kirsten', 'Passler', '$2y$10$dbqem/Ii2q0gJvhwD4kng.w.04w/JULZfupnilmWNfvRZQiIX0a4q', NULL),
(75, 'qriseborough1p@bloglovin.com', 'Quentin', 'Riseborough', '$2y$10$dbqem/Ii2q0gJvhwD4kng.w.04w/JULZfupnilmWNfvRZQiIX0a4q', 'b.png'),
(76, 'kleupold1q@infoseek.co.jp', 'Kameko', 'Leupold', '$2y$10$dbqem/Ii2q0gJvhwD4kng.w.04w/JULZfupnilmWNfvRZQiIX0a4q', 'b.png'),
(77, 'ceffemy1r@newyorker.com', 'Charity', 'Effemy', '$2y$10$dbqem/Ii2q0gJvhwD4kng.w.04w/JULZfupnilmWNfvRZQiIX0a4q', 'e.png'),
(78, 'yhawken1s@hexun.com', 'Yulma', 'Hawken', '$2y$10$dbqem/Ii2q0gJvhwD4kng.w.04w/JULZfupnilmWNfvRZQiIX0a4q', NULL),
(79, 'mbloomer1t@abc.net.au', 'Mickie', 'Bloomer', '$2y$10$dbqem/Ii2q0gJvhwD4kng.w.04w/JULZfupnilmWNfvRZQiIX0a4q', NULL),
(80, 'ogretton1u@wikimedia.org', 'Onfroi', 'Gretton', '$2y$10$dbqem/Ii2q0gJvhwD4kng.w.04w/JULZfupnilmWNfvRZQiIX0a4q', NULL),
(81, 'dtichelaar1v@oracle.com', 'Dulcinea', 'Tichelaar', '$2y$10$dbqem/Ii2q0gJvhwD4kng.w.04w/JULZfupnilmWNfvRZQiIX0a4q', NULL),
(82, 'ldudeney1w@craigslist.org', 'Lou', 'Dudeney', '$2y$10$dbqem/Ii2q0gJvhwD4kng.w.04w/JULZfupnilmWNfvRZQiIX0a4q', 'a.png'),
(83, 'fbraferton1x@hexun.com', 'Fifine', 'Braferton', '$2y$10$dbqem/Ii2q0gJvhwD4kng.w.04w/JULZfupnilmWNfvRZQiIX0a4q', 'a.png'),
(84, 'kturrill1y@psu.edu', 'Krystalle', 'Turrill', '$2y$10$dbqem/Ii2q0gJvhwD4kng.w.04w/JULZfupnilmWNfvRZQiIX0a4q', NULL),
(85, 'fbolens1z@ihg.com', 'Flossi', 'Bolens', '$2y$10$dbqem/Ii2q0gJvhwD4kng.w.04w/JULZfupnilmWNfvRZQiIX0a4q', 'd.png'),
(86, 'cbaird20@ted.com', 'Carly', 'Baird', '$2y$10$dbqem/Ii2q0gJvhwD4kng.w.04w/JULZfupnilmWNfvRZQiIX0a4q', NULL),
(87, 'hcowdery21@prnewswire.com', 'Ham', 'Cowdery', '$2y$10$dbqem/Ii2q0gJvhwD4kng.w.04w/JULZfupnilmWNfvRZQiIX0a4q', 'b.png'),
(88, 'vneesam22@usa.gov', 'Valdemar', 'Neesam', '$2y$10$dbqem/Ii2q0gJvhwD4kng.w.04w/JULZfupnilmWNfvRZQiIX0a4q', NULL),
(89, 'jloble23@ucoz.com', 'Joaquin', 'Loble', '$2y$10$dbqem/Ii2q0gJvhwD4kng.w.04w/JULZfupnilmWNfvRZQiIX0a4q', NULL),
(90, 'ujewes24@flavors.me', 'Ursuline', 'Jewes', '$2y$10$dbqem/Ii2q0gJvhwD4kng.w.04w/JULZfupnilmWNfvRZQiIX0a4q', NULL),
(91, 'jderle25@infoseek.co.jp', 'Jewelle', 'Derle', '$2y$10$dbqem/Ii2q0gJvhwD4kng.w.04w/JULZfupnilmWNfvRZQiIX0a4q', NULL),
(92, 'rnovic26@ycombinator.com', 'Riobard', 'Novic', '$2y$10$dbqem/Ii2q0gJvhwD4kng.w.04w/JULZfupnilmWNfvRZQiIX0a4q', 'c.png'),
(93, 'jdeerness27@nydailynews.com', 'Jenine', 'Deerness', '$2y$10$dbqem/Ii2q0gJvhwD4kng.w.04w/JULZfupnilmWNfvRZQiIX0a4q', 'e.png'),
(94, 'vmccloughlin28@google.com', 'Verene', 'McCloughlin', '$2y$10$dbqem/Ii2q0gJvhwD4kng.w.04w/JULZfupnilmWNfvRZQiIX0a4q', NULL),
(95, 'bborland29@tripadvisor.com', 'Bob', 'Borland', '$2y$10$dbqem/Ii2q0gJvhwD4kng.w.04w/JULZfupnilmWNfvRZQiIX0a4q', 'c.png'),
(96, 'aschuricke2a@opensource.org', 'Adolph', 'Schuricke', '$2y$10$dbqem/Ii2q0gJvhwD4kng.w.04w/JULZfupnilmWNfvRZQiIX0a4q', NULL),
(97, 'jczaple2b@fotki.com', 'Josepha', 'Czaple', '$2y$10$dbqem/Ii2q0gJvhwD4kng.w.04w/JULZfupnilmWNfvRZQiIX0a4q', 'd.png'),
(98, 'sgoom2c@senate.gov', 'Shay', 'Goom', '$2y$10$dbqem/Ii2q0gJvhwD4kng.w.04w/JULZfupnilmWNfvRZQiIX0a4q', NULL),
(99, 'hblazek2d@arizona.edu', 'Hildy', 'Blazek', '$2y$10$dbqem/Ii2q0gJvhwD4kng.w.04w/JULZfupnilmWNfvRZQiIX0a4q', NULL),
(100, 'ctestin2e@goo.ne.jp', 'Cyndia', 'Testin', '$2y$10$dbqem/Ii2q0gJvhwD4kng.w.04w/JULZfupnilmWNfvRZQiIX0a4q', NULL),
(101, 'dblanpein2f@ucsd.edu', 'Dean', 'Blanpein', '$2y$10$dbqem/Ii2q0gJvhwD4kng.w.04w/JULZfupnilmWNfvRZQiIX0a4q', 'e.png'),
(102, 'dleman2g@tripod.com', 'Dynah', 'Leman', '$2y$10$dbqem/Ii2q0gJvhwD4kng.w.04w/JULZfupnilmWNfvRZQiIX0a4q', NULL),
(103, 'htrusse2h@nyu.edu', 'Hedvige', 'Trusse', '$2y$10$dbqem/Ii2q0gJvhwD4kng.w.04w/JULZfupnilmWNfvRZQiIX0a4q', NULL),
(104, 'coutram2i@baidu.com', 'Collie', 'Outram', '$2y$10$dbqem/Ii2q0gJvhwD4kng.w.04w/JULZfupnilmWNfvRZQiIX0a4q', 'c.png'),
(105, 'eharhoff2j@skype.com', 'Erinna', 'Harhoff', '$2y$10$dbqem/Ii2q0gJvhwD4kng.w.04w/JULZfupnilmWNfvRZQiIX0a4q', 'e.png'),
(106, 'iandrivel2k@symantec.com', 'Iolande', 'Andrivel', '$2y$10$dbqem/Ii2q0gJvhwD4kng.w.04w/JULZfupnilmWNfvRZQiIX0a4q', NULL),
(107, 'cgyenes2l@salon.com', 'Carolynn', 'Gyenes', '$2y$10$dbqem/Ii2q0gJvhwD4kng.w.04w/JULZfupnilmWNfvRZQiIX0a4q', NULL),
(108, 'gbernocchi2m@earthlink.net', 'Grover', 'Bernocchi', '$2y$10$dbqem/Ii2q0gJvhwD4kng.w.04w/JULZfupnilmWNfvRZQiIX0a4q', 'e.png'),
(109, 'jgoulding2n@census.gov', 'Jo-ann', 'Goulding', '$2y$10$dbqem/Ii2q0gJvhwD4kng.w.04w/JULZfupnilmWNfvRZQiIX0a4q', 'b.png'),
(110, 'crookeby2o@miibeian.gov.cn', 'Christy', 'Rookeby', '$2y$10$dbqem/Ii2q0gJvhwD4kng.w.04w/JULZfupnilmWNfvRZQiIX0a4q', 'e.png'),
(111, 'ibraunter2p@hugedomains.com', 'Ives', 'Braunter', '$2y$10$dbqem/Ii2q0gJvhwD4kng.w.04w/JULZfupnilmWNfvRZQiIX0a4q', NULL),
(112, 'tholttom2q@statcounter.com', 'Tabbie', 'Holttom', '$2y$10$dbqem/Ii2q0gJvhwD4kng.w.04w/JULZfupnilmWNfvRZQiIX0a4q', 'd.png'),
(113, 'scourtney2r@nih.gov', 'Silvana', 'Courtney', '$2y$10$dbqem/Ii2q0gJvhwD4kng.w.04w/JULZfupnilmWNfvRZQiIX0a4q', 'a.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `TbArticleAuthors`
--
ALTER TABLE `TbArticleAuthors`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `IdArticle` (`IdArticle`),
  ADD KEY `IdUser` (`IdUser`);

--
-- Indexes for table `TbArticleCategories`
--
ALTER TABLE `TbArticleCategories`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `IdArticle` (`IdArticle`,`IdCategory`),
  ADD KEY `IdCategory` (`IdCategory`);

--
-- Indexes for table `TbArticleLike`
--
ALTER TABLE `TbArticleLike`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `IdArticle` (`IdArticle`,`IdUser`),
  ADD KEY `IdUser` (`IdUser`);

--
-- Indexes for table `TbArticles`
--
ALTER TABLE `TbArticles`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `TbArticleSources`
--
ALTER TABLE `TbArticleSources`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `IdArticle` (`IdArticle`),
  ADD KEY `IdSource` (`IdSource`);

--
-- Indexes for table `TbAuthors`
--
ALTER TABLE `TbAuthors`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `TbAuthorSocials`
--
ALTER TABLE `TbAuthorSocials`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `tbusersocials_ibfk_1` (`IdAuthor`);

--
-- Indexes for table `TbCategories`
--
ALTER TABLE `TbCategories`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `Name` (`Name`) USING HASH,
  ADD KEY `IdCategory` (`IdCategory`);

--
-- Indexes for table `TbComments`
--
ALTER TABLE `TbComments`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `IdComment` (`IdComment`),
  ADD KEY `IdArticle` (`IdArticle`),
  ADD KEY `IdUser` (`IdUser`);

--
-- Indexes for table `TbNotifications`
--
ALTER TABLE `TbNotifications`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `IdUser` (`IdUser`);

--
-- Indexes for table `TbPhotos`
--
ALTER TABLE `TbPhotos`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `IdArticle` (`IdArticle`);

--
-- Indexes for table `TbReactions`
--
ALTER TABLE `TbReactions`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `IdComment` (`IdComment`),
  ADD KEY `IdUser` (`IdUser`);

--
-- Indexes for table `TbSources`
--
ALTER TABLE `TbSources`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `TbUserFollows`
--
ALTER TABLE `TbUserFollows`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `Follower` (`Follower`,`Followed`),
  ADD KEY `Followed` (`Followed`);

--
-- Indexes for table `TbUsers`
--
ALTER TABLE `TbUsers`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `Email` (`Email`) USING HASH;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `TbArticleAuthors`
--
ALTER TABLE `TbArticleAuthors`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `TbArticleCategories`
--
ALTER TABLE `TbArticleCategories`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `TbArticleLike`
--
ALTER TABLE `TbArticleLike`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `TbArticles`
--
ALTER TABLE `TbArticles`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `TbArticleSources`
--
ALTER TABLE `TbArticleSources`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `TbAuthorSocials`
--
ALTER TABLE `TbAuthorSocials`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `TbCategories`
--
ALTER TABLE `TbCategories`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `TbComments`
--
ALTER TABLE `TbComments`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `TbNotifications`
--
ALTER TABLE `TbNotifications`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `TbPhotos`
--
ALTER TABLE `TbPhotos`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `TbReactions`
--
ALTER TABLE `TbReactions`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `TbSources`
--
ALTER TABLE `TbSources`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `TbUserFollows`
--
ALTER TABLE `TbUserFollows`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `TbUsers`
--
ALTER TABLE `TbUsers`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=115;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `TbArticleAuthors`
--
ALTER TABLE `TbArticleAuthors`
  ADD CONSTRAINT `tbarticleauthors_ibfk_1` FOREIGN KEY (`IdArticle`) REFERENCES `TbArticles` (`Id`),
  ADD CONSTRAINT `tbarticleauthors_ibfk_2` FOREIGN KEY (`IdUser`) REFERENCES `TbAuthors` (`Id`);

--
-- Constraints for table `TbArticleCategories`
--
ALTER TABLE `TbArticleCategories`
  ADD CONSTRAINT `TbArticleCategories_ibfk_1` FOREIGN KEY (`IdArticle`) REFERENCES `TbArticles` (`Id`),
  ADD CONSTRAINT `TbArticleCategories_ibfk_2` FOREIGN KEY (`IdCategory`) REFERENCES `TbCategories` (`Id`);

--
-- Constraints for table `TbArticleLike`
--
ALTER TABLE `TbArticleLike`
  ADD CONSTRAINT `tbarticlelike_ibfk_1` FOREIGN KEY (`IdArticle`) REFERENCES `TbArticles` (`Id`),
  ADD CONSTRAINT `tbarticlelike_ibfk_2` FOREIGN KEY (`IdUser`) REFERENCES `TbUsers` (`Id`);

--
-- Constraints for table `TbArticleSources`
--
ALTER TABLE `TbArticleSources`
  ADD CONSTRAINT `tbarticlesources_ibfk_1` FOREIGN KEY (`IdArticle`) REFERENCES `TbArticles` (`Id`),
  ADD CONSTRAINT `tbarticlesources_ibfk_2` FOREIGN KEY (`IdSource`) REFERENCES `TbSources` (`Id`);

--
-- Constraints for table `TbAuthors`
--
ALTER TABLE `TbAuthors`
  ADD CONSTRAINT `tbauthors_ibfk_1` FOREIGN KEY (`Id`) REFERENCES `TbUsers` (`Id`);

--
-- Constraints for table `TbAuthorSocials`
--
ALTER TABLE `TbAuthorSocials`
  ADD CONSTRAINT `tbauthorsocials_ibfk_1` FOREIGN KEY (`IdAuthor`) REFERENCES `TbAuthors` (`Id`);

--
-- Constraints for table `TbCategories`
--
ALTER TABLE `TbCategories`
  ADD CONSTRAINT `tbcategories_ibfk_1` FOREIGN KEY (`IdCategory`) REFERENCES `TbCategories` (`Id`);

--
-- Constraints for table `TbComments`
--
ALTER TABLE `TbComments`
  ADD CONSTRAINT `tbcomments_ibfk_1` FOREIGN KEY (`IdComment`) REFERENCES `TbComments` (`Id`),
  ADD CONSTRAINT `tbcomments_ibfk_2` FOREIGN KEY (`IdArticle`) REFERENCES `TbArticles` (`Id`),
  ADD CONSTRAINT `tbcomments_ibfk_3` FOREIGN KEY (`IdUser`) REFERENCES `TbUsers` (`Id`);

--
-- Constraints for table `TbNotifications`
--
ALTER TABLE `TbNotifications`
  ADD CONSTRAINT `TbNotifications_ibfk_1` FOREIGN KEY (`IdUser`) REFERENCES `TbUsers` (`Id`);

--
-- Constraints for table `TbPhotos`
--
ALTER TABLE `TbPhotos`
  ADD CONSTRAINT `tbphotos_ibfk_1` FOREIGN KEY (`IdArticle`) REFERENCES `TbArticles` (`Id`);

--
-- Constraints for table `TbReactions`
--
ALTER TABLE `TbReactions`
  ADD CONSTRAINT `TbReactions_ibfk_1` FOREIGN KEY (`IdComment`) REFERENCES `TbCategories` (`Id`),
  ADD CONSTRAINT `TbReactions_ibfk_2` FOREIGN KEY (`IdUser`) REFERENCES `TbUsers` (`Id`);

--
-- Constraints for table `TbUserFollows`
--
ALTER TABLE `TbUserFollows`
  ADD CONSTRAINT `tbuserfollows_ibfk_1` FOREIGN KEY (`Followed`) REFERENCES `TbUsers` (`Id`),
  ADD CONSTRAINT `tbuserfollows_ibfk_2` FOREIGN KEY (`Follower`) REFERENCES `TbUsers` (`Id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
