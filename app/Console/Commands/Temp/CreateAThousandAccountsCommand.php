<?php

namespace App\Console\Commands\Temp;

use App\Services\PagareFeaturesService;
use Illuminate\Console\Command;

class CreateAThousandAccountsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pagareAccounts:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    public function __construct(protected PagareFeaturesService $pagareFeaturesService)
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        array_map(function($doc) {
            dump($doc);

            try {
                $this->pagareFeaturesService->createAccount($doc, 0.1);
            } catch (\Exception $exception) {
                dump($doc, $exception->getMessage());
            }
        },
            $this->getDocs()
        );
    }

    private function getDocs(): array
    {
        return ['16930386766','12836012650','09174649663','05226689098','10040539679','05058877627','15891520770','80620990406','07191815698','07033471440','90012550000','71229988190','69869340091','71139045130','70906746493','25802490870','02565271484','00798352361','70010759140','46299623870','02206767201','00162080301','97379964534','23013680504','48905206867','96093668304','12487105682','88757285004','51694000125','00755987608','44945272204','10388477709','83844384200','03075739588','10385556713','00475037189','10656077760','05234337782','12487102667','59878304434','68308515991','94963045672','11964663431','87024110678','81556497253','83507779668','05877897357','73879614415','10433211873','03288305933','24877593802','76517764100','43276342200','01207171409','03309957748','86879910963','78297036391','59349042134','00860196607','03100964306','62749811520','92972934091','00206185146','05244523503','07969641652','04767785308','98151274034','00070199710','00788566393','00064135012','07500956959','09460142486','03344986279','11501837486','59220848953','51862832153','00030137403','00071768998','00030867630','00109184343','24627488300','14829853492','59436166168','47094133200','94659826368','54674360234','00098571176','00092256090','37533673620','98770535515','05091615458','07833421600','00143759310','83574565534','75358751300','06163757432','55190626334','80021905487','88967263015','11173710779','78309921187','00806460008','01595439757','01579105980','45821208220','11508751781','06388708447','00630696527','00019527659','01197095705','11508743681','62001132549','03125648726','56743475220','83114017304','06059291732','33534659368','45948127249','00145374190','46321217204','07072362665','01588971619','15990146701','62478861364','13148502612','14484681919','02247512046','12026992436','12026978603','12026975779','11683137671','11683149416','43572367972','10883079739','00495795500','85734810991','69556580930','06878317681','00075661403','05633727703','70037771183','83593900025','08586528625','69548692449','69516022200','00246806303','02508261785','70028344286','04110950210','01407067125','00726139637','98043480125','85945650625','00033060541','14440551785','01347728490','01271570696','12201468702','70768658152','13750475407','60111055300','87066670230','24731072034','71448004268','99193248334','41891805215','38695618315','66339090044','06291738775','94893730444','98376160400','28691563168','94283745634','70052674193','10095407421','86918524100','61979538034','07783573681','13364152748','04974420518','08803282408','00792242378','09698042539','08424220480','09009377423','06430310736','06161089742','06186249611','62551728215','06403988638','00618168508','29660386400','00630293910','10971145628','02393626913','74236040115','00548575118','10766811743','03047516774','65162129534','03879244502','96645156634','01863137130','03885299704','08792865712','63833441020','28205608814','98030990359','23652997840','07960253714','90592859304','00478297530','00329831585','00478352573','33512209874','00479860505','00479649367','00479848300','03818031126','30934497826','13515046810','31698074808','11472498810','22106434812','31345332866','02889675939','00481371540','00481320555','29346267844','14290275842','96229411091','27846192817','30907734812','33456398824','05478444685','00989485552','05511597155','29551221818','03759295410','02032077930','09627114707','02058737075','99045648504','79326749134','58504656187','02650811650','53659384291','53715500204','48046188808','11012289460','02906681156','86005098586','00330047302','04661484614','00477778500','90043731449','66148510553','44729650387','06052813350','12075606854','01606129180','08223504596','92704484600','89665929704','97402192172','05992659650','84020067791','91474779115','06059021603','06362577620','14070878602','00366557912','03550793642','07263411938','06953962933','76867064272','00050037412','51728605253','08772858885','08943002530','08286211600','00286735571','00210393564','13321509695','09889640406','00288593324','11645103803','00288542339','00535025661','11645129438','11645132498','11645078426','36646539634','45388270378','15266959797','00298075733','57804117191','11493536435','03605772617','01148780300','05888936332','11959392646','92058221672','11959403435','11959395408','11959411616','11960202723','11960204939','11960206630','11960206710','05834541437','33307893874','46314571391','02120587469','02101792443','72451548134','09535494619','79872115400','11356399495','03879115966','00204253330','00204276543','00204392535','00204674514','00204779537','00204856388','97664405904','00317895362','09452993979','00019572107','00041434692','00027419622','00042410614','00057352119','16069975804','11987331443','12043997432','12046277627','12046279913','14542268624','12046281810','12046293401','12046273710','11960445707','12046276906','12046283430','12046297652','12046293827','11960443682','12046309413','12024144608','12024135790','12023146780','13234249628','70593190181','72328061591','19176638898','27015317800','01603303944','25236563100','00332922308','00333283317','00333334329','95935398400','00150693389','00230856306','00230954316','00231709560','00332566323','61113857390','04963707403','00241215501','00235909394','48376280104','00235766348','00004185609','91757428020','00047815701','14527326805','27627528844','92527922953','25829288877','95057919504','04177764469','12025148470','60824111370','00043175643','09574962733','24861503825','04197730454','03090978946','77474953315','83947620268','93476396134','78968828253','26217141884','07447081175','04584784744','06225466940','18806934880','05606008440','02313498905','80104282215','00642391955','94358052568','01313694746','63163128572','07047529721','06001674965','02555323422','27387788871','95741887600','06212265720','10906709741','16389421451','04646954494','99497948468','07844754311','87429390110','00825147395','50855569840','09164489400','04425483898','07750041621','89695984134','01967955328','95875522372','77897919587','34746330824','52692017803','00289955386','61675467382','00062241567','11644848856','00008027005','00007140622','00003849929','93948670668','04275073401','73995738168','05254670924','14154763733','01877584096','31876943220','00001898558','23653891809','69972966534','05296419413','77617746172','60212993291','02157861572','70541442953','12721878700','76409317972','06250018425','82571112520','10906728452','93474989472','81464576491','11594151881','01211659496','83555390791','03424382981','08038808479','71947531034','07397503640','03869738650','79294324915','65561015320','00993938329','00768690080','80078311934','80100180663','02126191443','07413749602','46528538824','11683208951','00316607380','15579779763','00024868140','00018615570','11979849684','11979804664','02461292558','07594597974','10071616551','00208592369','03499805359','00062041126','00017037905','00057145598','00055288448','61846899320','00047965940','73809250910','00051094347','01646511018','02571096508','11350891754','70749866667','00011609664','00071179496','00044203578','00011521651','39132390068','00003827607','00006010393','00044027664','05246314413','55508120025','01812824025','00020313454','00316368539','39399982220','71687092591','09167097448','91712572253','00470890320','91721113568','77255178987','88313786353','70057942226','73091570282','74550063491','64354660504','88217299900','58167242900','14792451191','94796130187','84561378715','88891224715','06203900699','70307920925','70979855691','03083879881','00418686335','00076471233','01106103009','91757320091','67624413515','91757258272','07887458404','91757215972','80758851049','91755921268','83627502000','02761057619','00483767522','05396175478','91756510504','02766784276','04637531608','69949956234','91723795372','91756707553','91724040359','91724180100','01076430147','91724724304','91724872249','07770145139','83531181300','52417018187','00383761565','00383818508','44167545829','91721334300','91721474900','92407218515','80509789404','91720257515','72357410906','75559528749','85401382391','57814139368','91720389268','91721628649','91719976104','00443020370','91720010463','91720060134','11286678439','39726819415','61582760306','07882073695','36606740282','48387410900','02009454324','03669063056','91721490191','00462641325','91720117268','91719542287','91719801991','87839911587','03295658501','07925650613','70583770657','74306014215','84063262634','91720400253','91720427372','91709857315','91721318453','00037409271','71292896949','00041230698','00002884038','00004168518','00031408494','00036689408','00059607548','01583292284','96412097104','91720141487','03534297750','00066302005','07140794480','62837613649','91720664404','09632834720','00383878160','00384346529','19234862767','76826112272','00814271316','94543135687','00027126609','00021973407','04534806752','08518657717','02749302773','03807302948','06010403928','87030985915','00953866106','79490310930','77021274149','85488569049','71886346704','39963772072','45952388949','44168519015','72931817953','74178679015','01656642905','70108166201','00063090546','32872550968','07444268983','61006777920','07843680748','04875503903','94665729387','59916966168','76998614500','11736946684','11736281690','00065527062','00064185117','00090297962','83873333600','00009143475','00020577435','00682892602','99833301568','87431211015','01426000596','00268108595','89677781391','00484127594','00087312689','11648518613','01089850166','93508239691','30701872420','91824770006','00333326300','86826964287','01728120977','96137797104','01043542914','02993266403','02892833450','92757855115','70451736443','08295246658','03526251983','75248816300','84055073100','01477796347','83961097968','76584909204','05623888690','04460755319','04064482131','09522916730','02858826358','01316781160','02262283397','04920922655','61087033187','73286001953','65902432120','00359284922','91709555572','57145784904','07626515714','00429385110','00260518344','00252748565','00253593395','00253742307','04927922677','99151154587','98063553349','00029713641','00483434558','01937217400','85271527972','07683226696','09776038735','09888556746','07973232796','94411638134','79426611649','00253796318','11787920488','64537919515','01922252271','00253950333','91725127504','91725224372','00260698300','00260952389','62536737691','62547461900','62624695591','62639293915','62739727615','60586376356','05373044601','10570666724','07712668710','12311281437','12311072609','01659705371','12311130650','14542246655','12312117681','11107840740','07618860521','12311794655','12312001624','80429440200','03631208405','00259589683','62722387387','10943885990','11620802481','11101122625','00483703559','18959435740','04711713107','01607334054','16244797663','08016032770','70308991133','55309577300','47246618600','44996969415','29456843220','91757363653','91757282220','91755530153','12240612410','03392844470','03101633583','04372659601','04188223600','72693657334','03418832474','94756767320','00130933988','05039364563','03627981413','00376411155','57575320172','04815428689','85475319472','00027905306','91755816634','70958556920','00884008592','01685557198','08890850485','91709717149','91709750944','57433887091','57199523653','57328463449','01356643493','06680199484','04538516490','86320467720','03282721595','85884227000','91732280525','66017998587','60378792300','04322979106','07220524218','87442175520','44349815287','10629637415','12943696447','91710154934','11798110628','33551847568','00385822529','00950694533','00386683352','91756812500','00444851585','00444890564','91710065591','03131150602','91710065168','61453560572','91731097034','91731194900','91731143168','00445562501','00324421575','09061963370','00285001647','07825201701','11798066700','07147684303','03926108177','05894789583','58792910068','09155798551','70279166222','01208240277','12548250610','02546691236','03421404771','88421902091','70312680953','70318409453','70015201368','13439297683','70323585949','11790147743','11683506626','11683476611','89233255034','16735699602','37313037953','01361225742','24399973234','79833837700','10243045409','00014023318','00021945462','08898950748','00446636509','00446846309','05538014223','00446855561','00446860301','08311011729','00316111503','21976053803','06555075317','46584390349','72121645934','23695385898','14036091875','90062213504','00292635222','00292468300','15666862707','00292950330','00271996307','05660081142','20003352765','00271723505','06272654561','00726943789','11426795785','70327572272','92131727291','48952426843','11350916927','70208050000','11350926485','11426777701','11426782705','19651695706','11426806906','95398350544','11426828462','11426834942','42571565893','11182209785','11182214436','45378142334','05679220490','91722632534','91722780134','91723078972','91723469300','92440215449','43688535049','65005163034','00324497555','10212768476','00324776519','00324733542','02911853636','70327580291','62109588004','00315022701','00319729001','92832962149','70154973289','24202886968','12289696714','13172521605','84066717349','56224816867','94087709787','02378427506','46643508487','67940188020','15170772572','16223578253','03555926306','85490334053','84785896515','53424930210','10912763663','00977921360','01649911904','85722871400','48148784434','00251538389','03207871330','11939009723','00094392501','86238906634','78952611268','94818916749','95772219391','00320290395','08982002456','00320424502','00320538354','00320605566','81585845434','14965006798','60527487376','01200446925','26052369604','14580170601','04222042340','04489129106','10216157900','78644542591','02785519639','06199098978','39249519850','01639970479','05544413304','05660565778','11399337793','01067274944','00018794998','00049461540','00069533520','91721440925','91586437615','91726395391','91710774215','95988823653','00006375642','00019325606','00023654481','00032427654','00006585612','00027064905','81020406372','32237090297','84773316500','00851456707','91729114504','02301646769','91668042215','91727766415','91674581904','12275667784','06132636188','91727766920','04267651680','91675359920','01962503232','10976208679','59153288220','05873751595','01670170209','42623138591','80930964691','01933314540','10976176700','97157740672','00477873170','00827870345','01035748754','01050872703','01050626346','61539112187','12275575669','99695189768','49909037149','01065693680','01065160941','01082122971','01082246352','12275582606','00827963947','10976211629','01039613993','91711770434','91711827304','10976220709','01085836789','01123514500','01128808005','11433236885','12275446427','46473653520','12275467777','91719771049','12275534717','12275439722','10976162407','10976161427','10970915462','10970914903','10970925697','03558135563','11286674441','21392668115','02229763300','26494841287','35956755172','79235190134','02039548408','24532886368','15987132215','87654938268','03822742619','60115296310','02466152738','22388502870','37590205850','53275241087','21444315234','00586297502','00967078792','84784040315','02325699595','97470813934','88898768672','13730267744','02152862007','01663531323','08757282781','70199505152','85766106556','02280722208','01133237274','09173232467','22912225892','27009937800','45673591861','91554217920','03872542427','19723682737','12020144700','02063887802','10196611601','00470884517','01152537504','12087923426','32003870253','10953456994','12288793970','12291322443','10953458938','17611952714','10015256553','37383566068','70365397474','84273518600','12168804419','01575893584','62670761305','37022971897','32620033870','07772275412','71295673410','01018916792','23391321857','03481471394','31251710832','02611754322','00350313369','00355077302','05250974570','91712823272','08444525642','61338111370','00997743131','07880915907','00153171375','91720460400','91709784920','00376498331','81766297315','00937218111','05981892978','91709296020','00961794577','87024292172','25371480889','00944273564','91712904434','91713145120','00260489573','00254679560','03329532467','00258052589','00258325577','00258656506','00258988339','42707843857','91709458534','21828733172','91675464987','10943069750','91675693315','91675618968','91675847568','91675987653','00034558233','11493952498','11644748711','00340524537','12289176478','11736724436','02131734506','11676677941','00067316190','00048800058','00036667358','00013403605','00062729675','88856267500','07771239404','03535341450','03754130498','91675219320','04549665637','06435731780','00022980660','00020798016','00341200506','00341578592','06387239494','87593041204','83119167487','00948366397','03796143326','07884604477','02913306144','91675014272','31852248840','61312630515','00387206558'];
    }
}
