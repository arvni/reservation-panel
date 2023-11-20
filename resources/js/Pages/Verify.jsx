import {Head, useForm} from '@inertiajs/react';
import {Button, Container, CssBaseline, Stack, TextField} from "@mui/material";
import CodeField from "@/Components/CodeField";
import {CountdownCircleTimer} from 'react-countdown-circle-timer'
import {useState} from "react";


function Verify({mobile, showResendSMS,id}) {
    const {data, setData, post, processing, errors, setError, clearErrors} = useForm({
        code: '',
        mobile,
        id
    });

    const [showResend, setShowResend] = useState(showResendSMS)

    const submit = (e) => {
        e.preventDefault();
        if (check())
            post(route('verify',id));
    };
    const check = () => {
        clearErrors()
        let output = true;
        if (!data.mobile || !/^/.test(data.mobile)) {
            setError("mobile", "Please Enter a valid number")
            output = false
        }
        if (data.code.length !== 6) {
            setError("code", "Please Enter a valid code")
            output = false
        }
        return output
    }
    const handleShowResend = () => {
        setShowResend(true)
    }
    const handleResendCode = () => post(route("resend-sms",id), {
        onSuccess: () => {
            setShowResend(false);
        }
    });
    return (<>
            <Head title="Welcome"/>
            <Container component="main" maxWidth="xs" sx={{
                minHeight: "100dvh",
                display: "flex",
                justifyContent: "center",
                alignItems: "center"
            }}>
                <CssBaseline/>
                <form onSubmit={submit}>
                    <Stack spacing={2}>
                        <TextField name="mobile"
                                   label="Mobile"
                                   value={data.mobile}
                                   autoComplete="mobile"
                                   helperText={errors.mobile}
                                   error={errors?.mobile}
                                   disabled
                                   required/>
                        <CodeField length={6}
                                   name="code"
                                   value={data.code}
                                   autoComplete="code"
                                   isFocused={true}
                                   onChange={setData}
                                   required/>
                        <Stack direction={"row"} spacing={4} alignItems={"center"} justifyContent={"space-between"}>
                            {showResend ? <Button onClick={handleResendCode}>Resend Code</Button> :
                                <CountdownCircleTimer
                                    size={70}
                                    isPlaying
                                    duration={120}
                                    colors={['#004777']} onComplete={handleShowResend}
                                >
                                    {({remainingTime}) => (remainingTime / 60 | 0) + ":" + remainingTime % 60}
                                </CountdownCircleTimer>}
                            <Button variant="contained" type="submit" disabled={processing}>
                               Verify
                            </Button>

                        </Stack>
                    </Stack>
                </form>
            </Container>
        </>
    );
}


export default Verify;
