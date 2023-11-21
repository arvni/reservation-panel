import {useState} from "react";

import {useForm} from '@inertiajs/react';
import {
    Box,
    Button,
    FormControl,
    FormHelperText,
    InputAdornment,
    InputLabel,
    OutlinedInput,
    Stack,
    TextField, Typography
} from "@mui/material";
import CodeField from "@/Components/CodeField";
import {CountdownCircleTimer} from 'react-countdown-circle-timer'
import Layout from "@/Layouts/Layout.jsx";

function CancelAppointment({mobile, showResendSMS, id}) {
    const {data, setData, post, processing, errors, setError, clearErrors} = useForm({
        mobile,
    });


    const submit = (e) => {
        e.preventDefault();
        if (check())
            post(route('cancel-appointment'));
    };
    const check = () => {
        clearErrors()
        let output = true;
        if (!data.mobile || !/^((\+|00)?968)?[279]\d{7}$/.test(data.mobile)) {
            setError("mobile", "Please Enter a valid number")
            output = false
        }
        return output
    }
    const handleChange = (e) => setData("mobile", e.target.value);
    return (<Box sx={{mt: 3, mx: 2, p: 4, background: "rgba(255,255,255,0.7)", borderRadius: 4}} component={"form"}
                 onSubmit={submit}>
            <Typography> Appointment Cancellation </Typography>
            <Stack spacing={2} mt={2}>
                <FormControl variant="outlined" fullWidth required>
                    <InputLabel error={!!errors.mobile} htmlFor="outlined-adornment-mobile">Mobile
                        No.</InputLabel>
                    <OutlinedInput fullWidth
                                   value={data.mobile}
                                   inputMode={"numeric"}
                                   error={!!errors.mobile}
                                   helperText={errors?.mobile}
                                   required
                                   name="mobile"
                                   autoComplete="mobile"
                                   onChange={handleChange}
                                   id="outlined-adornment-mobile"
                                   startAdornment={
                                       <InputAdornment position="start">
                                           +968
                                       </InputAdornment>
                                   }
                                   label="Mobile No."
                    />
                    <FormHelperText error={!!errors.mobile}>{errors?.mobile}</FormHelperText>
                </FormControl>
                <Stack direction={"row"} spacing={4} alignItems={"center"} justifyContent={"center"}>
                    <Button variant="contained" type="submit" disabled={processing}>
                        Cancel
                    </Button>
                </Stack>
            </Stack>
        </Box>
    );
}

CancelAppointment.layout = (page) => <Layout children={page}/>

export default CancelAppointment;
