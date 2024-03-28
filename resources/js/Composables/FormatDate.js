import dayjs from "dayjs";

export default function useFormatDate() {

    /**
     * 受け取った時間文字列を YYYY/MM/DD にして返す
     *
     * @param date
     * @returns {string}
     */
    function getJADate(date) {
        return dayjs(date).format('YYYY/MM/DD');
    }

    /**
     * 受け取った時間文字列を YYYY/MM/DD HH:mm:ss にして返す
     *
     * @param date
     * @returns {string}
     */
    function getJADatetime(date){
        return dayjs(date).format('YYYY/MM/DD HH:mm:ss');
    }

    return {
        getJADate,
        getJADatetime
    };
}
