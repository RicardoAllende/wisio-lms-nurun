var tincan = new TinCan (
    {
        recordStores: [
            {
                endpoint: "https://nurun-ll.subitus.com/data/xAPI",
                username: "13613e2cdbc88ac86f4372a2709edb543475b403",
                password: "7f47b0ca9167971379d123cf99aff463fe452f7c",
                allowFail: false
            }
        ]
    }
);

var lrs = new TinCan.LRS(
    {
        endpoint: "https://nurun-ll.subitus.com/data/xAPI",
        username: "13613e2cdbc88ac86f4372a2709edb543475b403",
        password: "7f47b0ca9167971379d123cf99aff463fe452f7c",
        allowFail: false
    }
);

var tincanActivityId = "";

var myActivity = new TinCan.Activity({
    id: 'https://hola',
    objectType: 'Activity'
});