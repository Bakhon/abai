export const pgnoState = {
    state: {
        expAnalysisData: {},
        nearWells: {},

        calcedWell: {},
        well: {},
        lines: {},
        points: {},

        wellAnalysis: {},
        linesAnalysis: {},
        pointsAnalysis: {},
        mainSettings: {
            isSkError: false,
            isEditing: false,
            activeRightTabName: "techmode",
            isVisibleChart: true,
        },
        shgnSettings: {
            spmMin: 3,
            spmMax: 8,
            strokeLenMin: 2.5,
            strokeLenMax: 3,
            kpodMin: 0.6,
            pintakeMin: 20,
            gasMax: 10,
            inclStep: 10,
            groupPosad: 2,
            h2s: false,
            heavyDown: true,
            corrosion: "antiCorrosion",
            pumpTypes: ["32", "38", "44", "57", "70"],
            rodsTypes: ["19", "22"],
            komponovka: ["hvostovik"],
            stupColumns: "2",
            steelMark: ["D (API)", "15Х2ГМФ-D-sup"],
            kPodMode: true,
            kPodCalced: null,
        },
        shgnSettingsDefault: {
            spmMin: 3,
            spmMax: 8,
            strokeLenMin: 2.5,
            strokeLenMax: 3,
            kpodMin: 0.6,
            pintakeMin: 20,
            gasMax: 10,
            inclStep: 10,
            groupPosad: 2,
            h2s: false,
            heavyDown: true,
            corrosion: "antiCorrosion",
            pumpTypes: ["32", "38", "44", "57", "70"],
            rodsTypes: ["19", "22"],
            komponovka: ["hvostovik"],
            stupColumns: "2",
            steelMark: ["D (API)", "15Х2ГМФ-D-sup"],
            kPodMode: true,
            kPodCalced: null,
        },
        sensetiveSettings:
        {
            option1: {
                name: null,
                value1: null,
                value2: null,
                value3: null,
            },

            option2: {
                name: null,
                value1: null,
                value2: null,
                value3: null,
            },
            option3: {
                name: null,
                option1: null,
                value2: null,
                value3: null,
            },
        },

        curveSettings: {},

        analysisSettings: {},

        inclinometry: {},
        centralizer: {},
        centralizer_range: {},

        isEditing: false,
        isIntervals: false,
        kPodSettings: {},
        settingsMode: null,
    }
}