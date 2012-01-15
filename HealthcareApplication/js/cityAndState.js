var NUMBER_OF_STATES = 8;
var theState = new Array(NUMBER_OF_STATES);

for(var i = 0; i < NUMBER_OF_STATES; ++i)
{
    theState[i] = new Array();
}

//Cities in Australian Capital Territory
    theState[0][0] = "";
    theState[0][1] = "Williamsdale";
    theState[0][2] = "Naas";
    theState[0][3] = "Uriarra";
    theState[0][4] = "Tharwa";
    theState[0][5] = "Hall";
    theState[0][6] = "Canberra";
    theState[0].sort();
    theState[0][7] = "Other";
    
//Cities in New South Wales"
    theState[1][0] = "";
    theState[1][1] = "Newcastle";
    theState[1][2] = "Wollongong"
    theState[1][3] = "Wagga Wagga";
    theState[1][4] = "Tweed Heads";
    theState[1][5] = "Coffs Harbour";
    theState[1][6] = "Tamworth";
    theState[1][7] = "Albury";
    theState[1][8] = "Port Macquarie";
    theState[1][9] = "Orange";
    theState[1][10] = "Queanbeyan";
    theState[1][11] = "Dubbo";
    theState[1][12] = "Nowra-Bomaderry";
    theState[1][13] = "Bathurst";
    theState[1][14] = "Lismore";
    theState[1][15] = "Sydney";
    theState[1].sort();
    theState[1][16] = "Other";
    
//Cities in Victoria
    theState[2][0] = "";
    theState[2][1] = "Ballarat";
    theState[2][2] = "Wodonga";
    theState[2][3] = "Benalla";
    theState[2][4] = "Greater Shepparton";
    theState[2][5] = "Wangaratta";
    theState[2][6] = "Latrobe";
    theState[2][7] = "Greater Geelong";
    theState[2][8] = "Greater Bendigo";
    theState[2][9] = "Swan Hill";
    theState[2][10] = "Mildura";
    theState[2][11] = "Horsham";
    theState[2][12] = "Ararat";
    theState[2][13] = "Warrnambool";
    theState[2][14] = "Melbourne";
    theState[2].sort();
    theState[2][15] = "Other";
    
//Cities in Queensland
    theState[3][0] = "";
    theState[3][1] = "Logan City";
    theState[3][2] = "Redland City";
    theState[3][3] = "Ipswich";
    theState[3][4] = "Toowoomba";
    theState[3][5] = "Gold Coast";
    theState[3][6] = "Sunshine Coast";
    theState[3][7] = "Cairns";
    theState[3][8] = "Townsville";
    theState[3][9] = "Mackay";
    theState[3][10] = "Rockhampton";
    theState[3][11] = "Hervey Bay";
    theState[3][12] = "Ingham";
    theState[3][13] = "Mount Isa";
    theState[3][14] = "Brisbane";
    theState[3].sort();
    theState[3][15] = "Other";
    
//Cities in South Australia
    theState[4][0] = "";
    theState[4][1] = "Mount Gambier";
    theState[4][2] = "Whyalla";
    theState[4][3] = "Gawler";
    theState[4][4] = "Murray Bridge";
    theState[4][5] = "Port Augusta";
    theState[4][6] = "Port Pirie";
    theState[4][7] = "Port Lincoln";
    theState[4][8] = "Mount Barker";
    theState[4][9] = "Victor Harbor";
    theState[4][10] = "Goolwa";
    theState[4][11] = "Naracoorte";
    theState[4][12] = "Millicent";
    theState[4][13] = "Nuriootpa";
    theState[4][14] = "Renmark";
    theState[4][15] = "Tanunda";
    theState[4][16] = "Berri";
    theState[4][17] = "Strathalbyn";
    theState[4][18] = "Roxby Downs";
    theState[4][19] = "Loxton";
    theState[4][20] = "Moonta";
    theState[4][21] = "Clare";
    theState[4][22] = "Wallaroo";
    theState[4][23] = "Bordertown";
    theState[4][24] = "Ceduna";
    theState[4][25] = "Adelaide";
    theState[4].sort();
    theState[4][26] = "Other";

//Cities in Western Australia
    theState[5][0] = "";
    theState[5][1] = "Albany";
    theState[5][2] = "Armadale";
    theState[5][3] = "Bayswater";
    theState[5][4] = "Belmont";
    theState[5][5] = "Bunbury";
    theState[5][6] = "Canning";
    theState[5][7] = "Cockburn";
    theState[5][8] = "Fremantle";
    theState[5][9] = "Geraldton-Greenough";
    theState[5][10] = "Gosnells";
    theState[5][11] = "Joondalup";
    theState[5][12] = "Kalgoorlie";
    theState[5][13] = "Mandurah";
    theState[5][14] = "Melville";
    theState[5][15] = "Nedlands";
    theState[5][16] = "Rockingham";
    theState[5][17] = "South Perth";
    theState[5][18] = "Stirling";
    theState[5][19] = "Subiaco";
    theState[5][20] = "Swan";
    theState[5][21] = "Wanneroo";
    theState[5][22] = "Perth";
    theState[5].sort();
    theState[5][23] = "Other";

//Cities in Tasmania
    theState[6][0] = "";
    theState[6][1] = "Burnie";
    theState[6][2] = "Devonport";
    theState[6][3] = "Launceston";
    theState[6][4] = "Greater Hobart";
    theState[6].sort();
    theState[6][5] = "Other";
    
//Cities in Northern Territory
    theState[7][0] = "";
    theState[7][1] = "Palmerston";
    theState[7][2] = "Alice Springs";
    theState[7][3] = "Darwin";
    theState[7].sort();
    theState[7][4] = "Other";
    
function updateCity(index)
{
    var cityCombo = document.getElementById("city");
    cityCombo.options.length = 0;
    if(index > 0)
    {
        for (var i = 1; i < theState[index-1].length; ++i)
        {
            cityCombo.options[i] = new Option(theState[index-1][i]);
        }
    }
}

