var tincan = new TinCan (
    {
        recordStores: [
            {
                endpoint: "http://dev.academia.nurun.com.mx:3000/data/xAPI",
                username: "a39b3e5b3ad82a2a842245cee1675b55d5df6d9a",
                password: "81dc9a49b036f5b896afd97a7fcdb748849ca383",
                allowFail: false
            }
        ]
    }
);

var lrs = new TinCan.LRS(
    {
        endpoint: "http://dev.academia.nurun.com.mx:3000/data/xAPI",
        username: "a39b3e5b3ad82a2a842245cee1675b55d5df6d9a",
        password: "81dc9a49b036f5b896afd97a7fcdb748849ca383",
        allowFail: false
    }
);

var tincanActivityId = "";

var myActivity = new TinCan.Activity({
    id: 'https://hola',
    objectType: 'Activity'
});
